<?php
declare(strict_types=1);

namespace Hotel\Application\InputFilter\Reservation;


use Zend\I18n\Validator\PhoneNumber;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Date;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;
use Zend\Validator\Uuid;

class CreateReservationInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'required'   => true,
            'validators' => [
                new Uuid()
            ]
        ], 'apartment_id');

        $this->add([
            'required'   => true,
            'validators' => [
                new Date()
            ]
        ], 'date_start');

        $this->add([
            'required'   => true,
            'validators' => [
                new Date()
            ]
        ], 'date_end');

        $this->add([
            'required'   => true,
            'validators' => [
                new StringLength(['min' => 3])
            ]
        ], 'first_name');

        $this->add([
            'required'   => true,
            'validators' => [
                new StringLength(['min' => 3])
            ]
        ], 'last_name');

        $this->add([
            'required'   => true,
            'validators' => [
                new EmailAddress()
            ]
        ], 'email');

        $this->add([
            'required'   => true,
            'validators' => [
                new PhoneNumber()
            ]
        ], 'telephone');
    }
}