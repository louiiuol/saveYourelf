<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

if (false !== ini_get('xdebug.max_nesting_level')) {
    ini_set('xdebug.max_nesting_level', 500);
}

return $loader;
