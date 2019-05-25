<?php
declare(strict_types=1);


namespace Hotel\Application\Controller;


use Firebase\JWT\JWT;
use Hotel\Application\Exception\ApiProblemException;
use Hotel\Application\Model\Exception\UserNotExists;
use Hotel\Application\Model\User;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class LoginController extends AbstractRestfulController
{
    /** @var string */
    private $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function create($data)
    {
        try {
            $user = User::findByLoginAndPassword($data['login'], $data['password']);
        } catch (UserNotExists $exception) {
            throw new ApiProblemException('User not found', 404);
        }

        $payload = [
            "user_id" => $user->getAttribute('id'),
        ];

        return new JsonModel([
            'token' => JWT::encode($payload, $this->secretKey)
        ]);
    }
}