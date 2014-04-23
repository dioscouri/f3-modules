<?php
class ModulesBootstrap extends \Dsc\Bootstrap
{
    protected $dir = __DIR__;
    protected $namespace = 'Modules';
}

$app = new ModulesBootstrap();