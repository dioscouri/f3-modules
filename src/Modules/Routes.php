<?php

namespace Modules;

/**
 * Group class is used to keep track of a group of routes with similar aspects (the same controller, the same f3-app and etc)
 */
class Routes extends \Dsc\Routes\Group{
	
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * Initializes all routes for this group
	 * NOTE: This method should be overriden by every group
	 */
	public function initialize(){
		$this->setDefaults(
				array(
					'namespace' => '\Modules\Admin\Controllers',
					'url_prefix' => '/admin'
				)
		);
		
		$this->add( '/modules', array('GET', 'POST'), array(
								'controller' => 'Modules',
								'action' => 'display'
								));

		$this->add( '/modules/page/@page', array('GET', 'POST'), array(
				'controller' => 'Modules',
				'action' => 'display'
		));

		$this->add( '/modules/delete', array('GET', 'POST'), array(
				'controller' => 'Modules',
				'action' => 'delete'
		));

		$this->add( '/module/create', 'GET', array(
				'controller' => 'Module',
				'action' => 'create'
		));

		$this->add( '/module/add', 'POST', array(
				'controller' => 'Module',
				'action' => 'add'
		));

		$this->add( '/module/read/@id', 'GET', array(
				'controller' => 'Module',
				'action' => 'read'
		));

		$this->add( '/module/edit/@id', 'GET', array(
				'controller' => 'Module',
				'action' => 'edit'
		));

		$this->add( '/module/update/@id', 'POST', array(
				'controller' => 'Module',
				'action' => 'update'
		));

		$this->add( '/module/delete/@id', array('GET', 'DELETE'), array(
				'controller' => 'Module',
				'action' => 'delete'
		));

		$this->add( '/module/options', 'GET', array(
				'controller' => 'Module',
				'action' => 'options',
				'ajax' => true
		));
	}
}