<?php
header("Content-Type: text/html; charset=utf-8");
define('APPLICATION_PATH', realpath(dirname(__FILE__).'/private'));

date_default_timezone_set('Europe/Berlin');

session_name('wakeonlan');
session_start();

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/lib'),
    realpath(APPLICATION_PATH . '/controllers'),
    get_include_path(),
)));

require_once 'WakeUp/Autoloader.php';
$autoloader = new WakeUp\Autoloader();
$autoloader->register();
try{
$front = new WakeUp\Controller\Front();
$front->run();
}catch(Exception $e){
    var_dump($e->getTrace());
}
//var_dump(WakeUp\Config::$PORT);
//var_dump(new Test());