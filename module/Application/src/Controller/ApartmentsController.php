<?php
declare(strict_types=1);

namespace Hotel\Application\Controller;


use Hotel\Application\Exception\ApiProblemException;
use Hotel\Application\Model\Apartment;
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
        $collection = Apartment::all();

        return new JsonModel(
            $collection->toArray()
        );
    }
}