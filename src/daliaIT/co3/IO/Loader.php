<?php
/*/
class Loader
================================================================================
 
 Ke         | Vakue
 -----------|---------------------------------
 Author     | Oliver Anan \oliver@ananit.de
 Version    | 0.1.1
 Package    | co3
 
Converts arrays to objects.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\IO;
use \Exception,
    daliaIT\co3\core,
    daliaIT\co3\CoreUser,
    daliaIT\co3\IPlugin;

class Loader extends CoreUser
{
    protected 
        $core;
    
    public function load($data){
        $conf = $this->core->getConf();
        $typeDefinitions = $conf['types'];
        
        if(! is_array($data) ){
            return $data;
        }
        $value = ( isset( $data['value'] ) )
                ? $data['value']
                : null;
        
        if(! isset( $data['type'] ) ){
            if($value === null && !isset($data['isList'])){
                return $data;    
            }
            $type = 'string';
        } else {
            $type = $data['type'];
        }
        
        if( isset($data['isList']) && $data['isList'] ){
            $elements = array();
            if(!$value) $value = array();
            if(! is_array($value)){
                throw new Exception("list must be an array");
            }
            foreach($value as $key => $element){
                if(! isset($element['type']) ){
                    $element['type'] = $type;
                }
                $elements[$key] = $this->load($element);
            }
            return $elements;
        }
        
        if( isset($typeDefinitions[$type]) ){
            return $this->convertString($type, $data['value']);
        } else {
            $properties = array();
            if(!$value ) $value = array();
            foreach($value as $name => $proprty){
                $properties[$name] = $this->load($proprty);
            }
            return $type::inject($properties);
        }
    }
    
    public function convertString($type, $string){
        $conf = $this->core->getConf();
        $typeDefinitions = $conf['types'];
        if( isset( $typeDefinitions[$type]) ){
            try{
                return $this->core->IO->in($string, $typeDefinitions[$type]);    
            }
            catch ( Exception $e ){
                throw new Exception(
                    "An error occurred during conversion.",
                    0,
                    $e
                );
            }
        } else {
            throw new Exception(
                "An error occurred before conversation. "
                ."The type '$type' is not defined."
            );
        }
    }
    
    public function setCore(Core $core){
        $this->core = $core;
    }
}