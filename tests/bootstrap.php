<?php
echo sprintf('Is Composer loaded? %s%s', class_exists('\Composer\Autoload\ClassLoader', false) ? 'Yes' : 'No', PHP_EOL);
require_once dirname(__DIR__).'/vendor/autoload.php';
echo sprintf('Is Composer loaded? %s%s', class_exists('\Composer\Autoload\ClassLoader', false) ? 'Yes' : 'No', PHP_EOL);
