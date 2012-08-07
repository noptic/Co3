<?php
namespace com\daliaIT\co3;
 class Make implements IMake{
    /**
     * Create a new instance.
     * Chainable replacemnt for __construct 
     * @tag constructor, sugar
     */
     static function mk(){
         $class = get_called_class();
         $args = func_get_args();
         $argc = func_num_args();
         
         $code = "return new $class(";
         $codeArgs = array();
         for( $i=0; $i<$argc; $i++){
             $codeArgs[] = '$args'."[$i]";
         }
         $code .= implode(',',$codeArgs);
         $code .= ');';
         return eval($code);
     }
}
?>