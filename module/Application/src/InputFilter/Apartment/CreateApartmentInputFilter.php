<?php
declare(strict_types=1);

namespace Hotel\Application\InputFilter\Apartment;


use Hotel\Application\Validator\InArrayValidator;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Digits;
use Zend\Validator\StringLength;

class CreateApartmentInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'required'   => true,
            'validators' => [
                new StringLength(),
                new InArrayValidator(['haystack' => [
                    'ECONOMIC', 'STANDARD', 'LUXURY'
                ]])
            ]
        ], 'type');

        $this->add([
            'required'   => true,
            'validators' => [
                new StringLength(['min' => 10]),
            ]
        ], 'description');

        $this->add([
            'required'   => true,
            'validators' => [
                new Digits(),
            ]
        ], 'number');

        $this->add([
            'required'   => true,
            'validators' => [
                new Digits(),
            ]
        ], 'rooms_count');

        $this->add([
            'required'   => true,
            'validators' => [
                new Digits()
            ]
        ], 'price');
    }
}