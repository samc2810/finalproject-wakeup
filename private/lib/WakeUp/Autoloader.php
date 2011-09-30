<?php

namespace WakeUp;

/**
 * Description of Autoloader
 *
 * @author sarora
 */
class Autoloader {

    //put your code here

    public function register() {
	spl_autoload_register(array($this, 'loadClass'));
    }

    public function loadClass($class) {
	$path = str_replace('\\', '/', $class) . '.php';
	require_once $path;
    }
}

    