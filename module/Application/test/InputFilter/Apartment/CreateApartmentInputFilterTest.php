<?php
declare(strict_types=1);

namespace Hotel\Application\Test\InputFilter\Apartment;


use Hotel\Application\InputFilter\Apartment\CreateApartmentInputFilter;
use PHPUnit\Framework\TestCase;

class CreateApartmentInputFilterTest extends TestCase
{
    public function testItValidates(): void
    {
        $data = [
            'type'        => 'STANDARD',
            'description' => 'This is desc',

            'number'      => 5,
            'rooms_count' => 2,
            'beds_count'  => 3,

            'price' => 11
        ];

        $inputFilter = new CreateApartmentInputFilter();
        $inputFilter->init();
        $inputFilter->setData($data);

        self::assertTrue($inputFilter->isValid());
    }
}