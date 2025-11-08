<?php
namespace Mos\Kernel;

class KernelCore
{
    protected $app;
    public function __construct($app){
        $this->app = $app;
    }

    public function init(){
        // placeholder - load modules from DB, register them
    }
}