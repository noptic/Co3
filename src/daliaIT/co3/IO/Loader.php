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
    daliaIT\co3\Inject,
    daliaIT\co3\IPlugin;

class Loader extends Inject
{
    protected 
        $validate = true;
    
    public function load($data, $typeDefinitions){
        if(! is_array($data) ){
            return $data;
        }
        $value = ( isset( $data['value'] ) )
                ? $data['value']
                : null;
        
        if(! isset( $data['type'] ) ){
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
                $elements[$key] = $this->load($element, $typeDefinitions);
            }
            return $elements;
        }
        
        if( array_key_exists($type, $typeDefinitions )){
            return $this->convertString($type, $data['value'], $typeDefinitions);
        } else {
            $properties = array();
            if(!$value ) $value = array();
            foreach($value as $name => $proprty){
                $properties[$name] = $this->load($proprty, $typeDefinitions);
            }
            return $type::inject($properties);
        }
    }
    
    public function convertString($type, $string, $typeDefinitions){
        if(! array_key_exists($type, $typeDefinitions ) ){
            throw new Exception(
                "An error occurred before conversation. "
                ."The type '$type' is not defined."
            );
        }
        if( $this->validate ){
            $this->validateString( $type, $string, $typeDefinitions);
        } 
        if( isset( $typeDefinitions[$type]['converter'] ) ){
            $converterClass = $typeDefinitions[$type]['converter'];
            if(! isset($this->converters[$converterClass]) ){
                $this->converters[$converterClass] = $converterClass::mk();
            }
            $converter = $this->converters[$converterClass];
            try{
                return $converter->fromString($string);    
            }
            catch ( Exception $e ){
                throw new Exception(
                    "An error occurred during conversion.",
                    0,
                    $e
                );
            }
        } else {
            return $string;
        }
    }
    
    public function validateString($type, $string, $typeDefinitions){
        if( isset( $typeDefinitions[$type]['pattern'] ) ){
            $result = preg_match(
                $typeDefinitions[$type]['pattern'],
                $string
            );
            if($result === false){
                throw new Exception(
                    "An error occurred before validation. " 
                    ."Please check if the validation pattern is corret."
                );
            }
            if($result === 0){
                throw new Exception(
                    "An error occurred during validation. "
                    ."The value does not match the validation pattern"
                );
            }
        }
    }
    
}