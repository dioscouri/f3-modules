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
		$this->addCrudGroup( 'Modules', 'Module' );

		$this->add( '/module/options', 'GET', array(
				'controller' => 'Module',
				'action' => 'options',
				'ajax' => true
		));
	}
}