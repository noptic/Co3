<?php
namespace daliaIT\co3;
class  Inject extends Make implements IInject
{
    public static function inject($properties){
        $instance = static::mk();
        if(! $properties){
            $properties = array();
        }
        foreach( static::getInjectableProperties() as $property ){
            if( array_key_exists( $property, $properties ) ){
                $instance->$property = $properties[$property];
            }
        }
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
}
?>