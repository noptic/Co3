<?php
namespace daliaIT\co3\h2o;
use Exception,
    H2o_File_Loader,
    daliaIT\co3\Core,
    daliaIT\co3\ICoreUser,
    daliaIT\co3\IInject;
    
class ResourceTemplateLoader extends H2o_File_Loader 
implements ICoreUser, IInject
{    
    function __construct($options = array()) {            
    	$this->searchpath = array();
		$this->setOptions($options);
    }
    
    #:string   
    function get_template_path($search_path, $filename){
        $filename = $this->core->IO->file->search($filename);
        if($filename !== null){
            return $filename;
        } else {
            throw new Exception('TemplateNotFound - Looked for template: ' . $filename);
        }
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