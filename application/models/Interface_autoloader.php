<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Interface_autoloader {

    public function __construct() {
        $this->init_autoloader();
    }

    private function init_autoloader(){
        spl_autoload_register(function($classname){
            if( strpos($classname,'interface') !== false ){
                strtolower($classname);
                require('application/interfaces/'.$classname.'.php');
            }
        });
    }

}