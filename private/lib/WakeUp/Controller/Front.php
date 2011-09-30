<?php

namespace WakeUp\Controller;

/**
 * Description of Front
 *
 * @author sarora
 */
class Front {

    private $layoutFile;

    public function __construct() {
	$this->layoutFile = APPLICATION_PATH . '/layouts/Layout.html';
    }

    public function run() {
	$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'index';
	$controllerName = ucfirst($controllerName) . 'Controller';
	if (!class_exists($controllerName)) {
	    throw new \Exception('Controller not found');
	    return;
	}
	$controller = new $controllerName();
	$action = isset($_GET['action']) ? $_GET['action'] : $controller->getDefaultAction();

	if ($controller->actionExists($action)) {
	    $this->makeOutput($controller, $action);
	} else {
	    throw new \Exception('The Action does not exist');
	}
    }

    private function makeOutput(\WakeUp\Controller\ActionAbstract $controller, $action) {
	$method = $action . 'Action';
	$html = $controller->$method();
	$ajax = $controller->isAjax();
	$out = '';
	if (!$ajax) {
	    $file = fopen($this->layoutFile, 'r');
	    while (!feof($file)) {
		$line = fgets($file);
		if ($session['loggedin']) {
		    $adminNavi = '';
		    if (isset($session['isAdmin']) && $session['isAdmin'] === true) {
			$adminNavi = '<div id="admin-navi">
                                <div><a href="index.php">Start</a></div>
                                <div><a href="index.php?action=jobview">Wake-Up Planer</a></div>
                                <div><a href="index.php?action=vlan">Vlan-Übersicht</a></div>
                                <div><a href="index.php?action=logview">Log</a></div>
                             </div>';
		    } else {
			$adminNavi = '<div id="admin-navi">
                                <div><a href="index.php">Start</a></div>
                                <div><a href="index.php?action=jobview">Wake-Up Planer</a></div>
                             </div>';
		    }
		    $header = '<div id="header-navi">'
			    . $adminNavi
			    . '<div id="logout">
                                <a href="index.php?action=logout">Abmelden</a>
                              </div>
                        </div>';
		    $line = str_replace('{header}', $header, $line);
		}
		else
		    $line = str_replace('{header}', '', $line);
		$out .= str_replace('{content}', $str, $line);
	    }

	    echo $out;
	}else
	    echo $str;
    }

}
