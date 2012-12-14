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
        if(! is_array($data) ){
            return $data;
        } elseif( isset($data['isList']) && $data['isList']) {
            $items = array();
            foreach( ( (array) $data['value'] ) as $index => $item ){
                if(isset( $data['type']) ){
                    $items[$index] = $this->load(array(
                        'type' => $data['type'],
                        'value' => $item
                    )); 
                } else {
                    $items[$index] = $this->load($item) ;
                }
            } 
            return $items;
        } elseif(! isset($data['type'])){
            $items = array();
            foreach($data as $name => $item){
                $items[$name] = $this->load($item);
            }
            return $items;
        } else {
            if(! isset($data['value']) ){
                $data['value'] = null;
            }
            if(null !== 
                ($conv = $this->core->getConfValue("types/{$data['type']}"))
            ){
                return $this->convertString($conv, $data['value']);
            }
            $class = $data['type'];
            $properties = array();
            foreach( ( (array) $data['value'] ) as $name => $property ){
                $properties[$name] = $this->load($property);
            }
            $obj = $class::inject($properties);
            if( method_exists($obj, '__wakeup ') ) {
                $obj->__wakeup();
            }
            return $obj;
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