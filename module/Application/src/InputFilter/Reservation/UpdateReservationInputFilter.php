<?php
declare(strict_types=1);


namespace Hotel\Application\InputFilter\Reservation;


use Hotel\Application\Validator\InArrayValidator;
use Zend\InputFilter\InputFilter;

class UpdateReservationInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'required'   => true,
            'validators' => [
                new InArrayValidator(['haystack' => [
                    'CANCELLED', 'PAID'
                ]])
            ]
        ], 'status');
    }
}