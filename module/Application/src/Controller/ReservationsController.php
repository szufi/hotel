<?php
declare(strict_types=1);


namespace Hotel\Application\Controller;


use Hotel\Application\Exception\ApiProblemException;
use Hotel\Application\Model\Apartment;
use Hotel\Application\Model\Exception\UserNotExists;
use Hotel\Application\Model\Reservation;
use Hotel\Application\Model\User;
use Illuminate\Database\Eloquent\Builder;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;


class ReservationsController extends AbstractRestfulController
{
    public function create($data): ViewModel
    {
        if (!Apartment::{'find'}($data['apartment_id'])) {
            throw new ApiProblemException('Apartment not exists', 404);
        }

        if (!Reservation::isAvailable(
            $data['apartment_id'], $data['date_start'], $data['date_end'])
        ) {
            throw new ApiProblemException('Apartment is not available in provided period', 409);
        }

        try {
            $user = User::findByEmail($data['email']);
        } catch (UserNotExists $exception) {
            $user = User::fromArray($data);
        }

        $data['user_id'] = $user->getAttribute('id');
        $reservation     = Reservation::fromArray($data);

        return new JsonModel(
            $reservation->toArray()
        );
    }

    public function get($id): ViewModel
    {
        /** @var Reservation|null $reservation */
        $reservation = Reservation::{'with'}('user')->find($id);

        if (!$reservation) {
            throw new ApiProblemException('Reservation not found', 404);
        }

        return new JsonModel(
            $reservation->toArray()
        );
    }

    public function getList()
    {
        /** @var Builder $collection */
        $collection = Reservation::{'with'}('apartment', 'user');
        $collection = $collection->get();

        return new JsonModel(
            $collection->{'toArray'}()
        );
    }

    public function update($id, $data)
    {
        /** @var Reservation|null $reservation */
        $reservation = Reservation::{'find'}($id);

        if (!$reservation) {
            throw new ApiProblemException('Reservation not found', 404);
        }

        $reservation->setAttribute('status', $data['status']);
        $reservation->save();

        return new JsonModel(
            $reservation->toArray()
        );
    }
}