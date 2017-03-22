<?php
/**
 * Simple PHP Container
 * Created by PhpStorm.
 * User: Alex Capalneanu
 * Date: 3/22/2017
 * Time: 9:07 AM
 */
namespace Webcounted\SimpleContainer;

use Interop\Container\ContainerInterface;

class SimpleContainer implements ContainerInterface
{
    private $services;
    private $mappings;

    public function __construct(){
        $this->services = [];
        $this->mappings = [];
}

    public function get($serviceName){
       if(!array_key_exists($serviceName, $this->services)){
            $this->services[$serviceName] = $this->serviceFactory($serviceName);
       }
       return $this->services[$serviceName];
    }

    public function has($serviceName){
        return isset($this->services[$serviceName]);
    }

    public function setClass($name, \Closure $callback){
        $this->mappings[$name] = $callback;
    }


    public function setValue($name, $value){
        $this->services[$name] = $value;

    }


    private function serviceFactory($name){
        if (array_key_exists($name, $this->mappings)){  //we have this already
            $callback = $this->mappings[$name];
            return $callback();

        }else {
            throw new Exception('Service not registered in container');
        }

    }
}

