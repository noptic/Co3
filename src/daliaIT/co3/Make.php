<?php
namespace daliaIT\co3;
use ReflectionClass;
class Make implements IMake{
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
}
?>