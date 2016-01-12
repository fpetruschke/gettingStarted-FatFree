<?php
/**
 * @author  Florian Petruschke <f.petruschke@dzh-online.de>
 * @date    11.01.16  -  14:04
 * @version 1.0
 */

// following four lines must be included for autoloading and routing
require ("vendor/autoload.php");
$f3 = \Base::instance();
$f3->config("app/config/config.ini");
$f3->config("app/config/routes.ini");

new Session();

$f3->run();