<?php
declare(strict_types=1);

use Zend\Mvc\Application;

chdir(dirname(__DIR__));

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../config/application.config.php';

$app = Application::init($config);
$app->run();

