<?php
declare(strict_types=1);


namespace Hotel\Application\Validator;


use Zend\Validator\InArray;

class InArrayValidator extends InArray
{
    /** @var string */
    protected $stack;
    protected $messageVariables = [
        'haystack' => 'stack',
    ];
    protected $messageTemplates = [
        self::NOT_IN_ARRAY => 'Expected one of the following values: %haystack%',
    ];

    /**
     * InArrayValidator constructor.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        parent::__construct($options);

        $this->stack = implode(', ', $options['haystack']);
    }
}