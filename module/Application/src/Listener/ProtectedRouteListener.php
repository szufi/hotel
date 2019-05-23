<?php
declare(strict_types=1);


namespace Hotel\Application\Listener;


use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Hotel\Application\Model\User;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class ProtectedRouteListener extends AbstractListenerAggregate
{
    /** @var string */
    private $secretKey;
    /** @var string */
    private $algorithm;

    public function __construct(string $secretKey, string $algorithm)
    {
        $this->secretKey = $secretKey;
        $this->algorithm = $algorithm;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'when'], 1000);
    }

    public function when(MvcEvent $event)
    {
        /** @var Request $request */
        $request = $event->getRequest();
        /** @var RouteMatch $routeMatch */
        $routeMatch = $event->getRouteMatch();

        /** @var array $protected */
        $protected = $routeMatch->getParam('protected', []);
        $action    = $this->resolveAction($request, $routeMatch);

        if (!in_array($action, $protected)) {
            return null;
        }

        $header = $request->getHeader('Authorization', null);
        if (!$header) {
            return new ApiProblemResponse(
                new ApiProblem(403, "Missing 'Authorization' header")
            );
        }

        [, , $token] = explode(' ', $header->toString());
        if (substr_count($token, '.') !== 2) {
            return new ApiProblemResponse(
                new ApiProblem(403, "'Authorization' header invalid format")
            );
        }

        try {
            $decoded = (array)JWT::decode($token, $this->secretKey, array($this->algorithm));
        } catch (SignatureInvalidException $exception) {
            return new ApiProblemResponse(
                new ApiProblem(403, "'Authorization' header could not be verified")
            );
        }

        $userId = $decoded['user_id'];

        $user = User::{'find'}($userId);
        if ($user && $user->is_admin) {
            return null;
        }

        return new ApiProblemResponse(
            new ApiProblem(403, "Unauthorized")
        );
    }

    protected function resolveAction(Request $request, RouteMatch $routeMatch): string
    {
        $action = $request->getMethod();
        if ($action !== 'GET') {
            return $action;
        }

        return $routeMatch->getParam('id', false) ? $action : $action . '_LIST';
    }
}