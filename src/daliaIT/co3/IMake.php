<?php
namespace daliaIT\co3;
interface IMake {
    /**
     * Create a new instance.
     * Chainable replacemnt for __construct 
     * @tag constructor, sugar
     */
     static function mk();
     
     static function mkFromArray($args);
     
     static function mkMany($argsArray);
}
?>