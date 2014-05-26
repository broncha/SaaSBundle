<?php
/**
 * Created by PhpStorm.
 * User: broncha
 * Date: 5/25/14
 * Time: 5:13 PM
 */
if (!is_file($autoloadFile = __DIR__.'/../vendor/autoload.php')) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

require $autoloadFile;