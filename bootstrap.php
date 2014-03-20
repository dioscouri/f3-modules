<?php 
class ModulesBootstrap extends \Dsc\Bootstrap{
	protected $dir = __DIR__;
	protected $namespace = 'Modules';
	
	/**
     * Dont do anything for site right now
	 */
	protected function runSite(){}
}
$app = new ModulesBootstrap();