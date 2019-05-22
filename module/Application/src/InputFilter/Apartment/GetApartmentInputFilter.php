<?php
declare(strict_types=1);


namespace Hotel\Application\InputFilter\Apartment;


use Zend\InputFilter\InputFilter;
use Zend\Validator\Callback;
use Zend\Validator\Date;

class GetApartmentInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'required'   => true,
            'validators' => [
                new Callback([
                    'message'  => 'Expected query param, eg. filter={"date_start": "2020-01-01", "date_end": "2020-01-02"}',
                    'callback' => function ($value) {
                        $filter = json_decode($value, true);

                        if (!isset($filter['date_start']) || !isset($filter['date_end'])) {
                            return false;
                        }

                        $validator = new Date();
                        if(!$validator->isValid($filter['date_start']) || !$validator->isValid($filter['date_end'])) {
                            return false;
                        }

                        return true;
                    }
                ])
            ]
        ], 'filter');
    }
}