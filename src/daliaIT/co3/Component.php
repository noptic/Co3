<?php
/*/
type:       class
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    [0,0,1,0]
tags:       [system core, base, helper]
================================================================================
Component
================================================================================
Base class for co3 components like filters and plugins.

Adds some helper methods.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3;
use Exception;
class Component implements IClassHasResource,ICoreUser,IInject,IMake{
    
    #:string
    public function getText($path){
        if($this->core === null){
            throw new Exception('No core set.');
        }
        $path = str_replace('\\','/',$path);
        $result = $this->core->IO->file->in($path);
        if(!$result){
            throw new Exception("Could not find text: '$path'");
        }
        return $result;
    }
    
    #:string
    public function formatArgs($path){
       $args = func_get_args();
        array_shift($args);
        return $this->formatArray($path, $args);
    }
    
    #:string
    public function formatArray($path, array $args){
        if($this->core === null){
            throw new Exception('No core set.');
        }
        return  vsprintf($this->getText($path), $args);
    }
    
    #:mixed
    public function getResource($path){
        return $this->core->IO->resource->in($path);
    }
    
    #@import daliaIT\co3\Inject#
    
        public static function inject($properties){
            $class = get_called_class();
            $args = func_get_args();
            array_shift($args);
            if($args){
                $reflect = new ReflectionClass($class); 
                $instance = $reflect->newInstanceArgs($args);
            } else {
                $instance = new $class();
            }
                
            if($properties){
                foreach( static::getInjectableProperties() as $property ){
                    if( array_key_exists( $property, $properties ) ){
                        $instance->$property = $properties[$property];
                    }
                }   
            }
            $instance->postInject();
            return $instance;
        }
        
        public static function injectMany($propertiesArray){
            $objects = array();
            foreach($propertiesArray as $key => $properties){
                $objects[$key] = static::inject( $properties );
            }
            return $objects;
        }
        
        public function extract(){
            $result = array();
            foreach( static::getInjectableProperties() as $property ){
                $result[$property] = $this->$property;
            }
            return $result;
        }
        
        protected static function getInjectableProperties(){
            return array_keys( get_class_vars( get_called_class() ) );
        }
        
        protected function postInject(){
            return $this;
        }
    #@#
    #@import daliaIT\co3\Make#
    
        protected static $reflectionClasses = array();
        /**
         * Create a new instance.
         * Chainable replacemnt for __construct 
         * @tag constructor, sugar
         */
        public static function mk(){
            return static::mkFromArray( func_get_args() );
        }
         
        public static function mkFromArray($args=array()){
            $class = get_called_class();
            if( count($args) == 0 ){
                return new $class();
            }
            if(! array_key_exists($class, self::$reflectionClasses) ){
                self::$reflectionClasses[$class] = new ReflectionClass($class);
            }
            $reflect = self::$reflectionClasses[$class];
            return $reflect->newInstanceArgs($args);
        }
         
        public static function mkMany($arrayOfArgs){
            $result = array();
            foreach($arrayOfArgs as $args){
                $result[] = static::mkFromArray($args);
            }
            return $result;
        } 
        
        public function __construct(){}
    #@#
    #@import daliaIT\co3\CoreUser#
    
        protected
        #:Core    
            $core;
            
        
        #:Core
        public function getCore(){
            return $this->core;
        }
        
        #:this
        public function setCore(Core $core){
            $this->core = $core;
            $this->injectCore( get_object_vars($this) );
            return $this;
        }
        
        #:this
        protected function injectCore($targets){
            foreach($targets as $target){
                if(
                    $target instanceof ICoreUser 
                    && $target->getCore() !== $this->core
                ){
                    $target->setCore($this->core);    
                }
                if(is_array($target)){
                    $this->injectCore($target);
                }
            }
            return $this;
        }
    #@#
}