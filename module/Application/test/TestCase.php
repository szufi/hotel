<?php
declare(strict_types=1);

namespace Hotel\Application\Test;


use Zend\Mvc\Application;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public static $app;

    public function setUp()
    {
        if (!static::$app) {
            $config      = require_once __DIR__ . '/../../../config/application.config.php';
            static::$app = Application::init($config);
        }
    }
}