<?php
declare(strict_types=1);

namespace Hotel\Application\Test\InputFilter\Reservation;


use Hotel\Application\InputFilter\Reservation\CreateReservationInputFilter;
use PHPUnit\Framework\TestCase;

class CreateReservationInputFilterTest extends TestCase
{
    public function testItValidates(): void
    {
        $data = [
            'apartment_id' => '46c8184b-72f4-48e5-9821-bea4012e823e',

            'date_start' => '2027-01-01',
            'date_end'   => '2027-02-01',

            'first_name' => 'Jan',
            'last_name'  => 'Kowalski',

            'email'     => 'jan.kowalski@test.pl',
            'telephone' => '7567567'
        ];

        $inputFilter = new CreateReservationInputFilter();
        $inputFilter->init();
        $inputFilter->setData($data);

        self::assertTrue($inputFilter->isValid());
    }
}