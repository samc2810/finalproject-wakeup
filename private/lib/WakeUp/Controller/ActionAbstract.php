<?php

namespace WakeUp\Controller;

/**
 * Description of ActionAbstract
 *
 * @author sarora
 */
abstract class ActionAbstract {

    protected $defaultAction = 'index';
    /*
      protected $currentAction = null;
      private $contollerName = null;

      public function __construct(){
      $class = get_class($this);
      $splittedClass = explode('\\', $class);
      $class = $splittedClass[count($splittedClass) -1];
      $controller = str_replace('Controller', '', $class);
      $this->contollerName = strtolower($controller);
      }

      public function getCurrentAction() {
      return $this->currentAction;
      }

      public function setCurrentAction($currentAction) {
      $this->currentAction = $currentAction;
      }
     */

    public function getDefaultAction() {
	return $this->defaultAction;
    }

    public function actionExists($name) {
	$fullAction = $name . 'Action';
	return method_exists($this, $fullAction);
    }

    public function isAjax() {
	$ajax = false;
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
	    $ajax = true;
	
	return $ajax;
    }
    
    protected function _redirect($controller, $action=null){
	if(!$action)
	    $action = $this->getDefaultAction ();
	
	header('Location: index.php?controller='.$controller.'&action='.$action);
    }

}
