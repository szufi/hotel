<?php
declare(strict_types=1);

namespace Hotel\Application\Test\Model\User;


use Hotel\Application\Model\Reservation;
use Hotel\Application\Test\TestCase;
use Illuminate\Database\QueryException;

class ReservationTest extends TestCase
{
    public function testItCreatesFromArray(): void
    {
        $data = [
            'apartment_id' => '46c8184b-72f4-48e5-9821-bea4012e823e',

            'date_start' => '2027-01-01',
            'date_end'   => '2027-02-01',

            'first_name' => 'Jan',
            'last_name'  => 'Kowalski',

            'email'     => 'jan.kowalski@test.pl',
            'telephone' => '7567567',

            'user_id' => '46c8184b-72f4-48e5-9821-bea4012e823e'
        ];

        self::expectException(QueryException::class);
        Reservation::fromArray($data);
    }
}