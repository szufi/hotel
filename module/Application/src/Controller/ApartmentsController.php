<?php
declare(strict_types=1);

namespace Hotel\Application\Controller;


use Hotel\Application\Exception\ApiProblemException;
use Hotel\Application\Model\Apartment;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ApartmentsController extends AbstractRestfulController
{
    public function create($data)
    {
        $apartment = Apartment::fromArray($data);
        if ($apartment->exists()) {
            throw new ApiProblemException('Model already exists', 409);
        }

        $apartment->save();

        return new JsonModel(
            $apartment->toArray()
        );
    }

    public function getList()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $filter  = $request->getQuery('filter', []);

        if (empty($filter)) {
            return new JsonModel(
                Apartment::all()->toArray()
            );
        }

        $filter     = json_decode($filter, true);
        $collection = Apartment::findAllAvailable($filter['date_start'], $filter['date_end']);

        return new JsonModel(
            $collection->toArray()
        );
    }
}