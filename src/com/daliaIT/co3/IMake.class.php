<?php
namespace com\daliaIT\co3;
interface IMake {
    /**
     * Create a new instance.
     * Chainable replacemnt for __construct 
     * @tag constructor, sugar
     */
     static function mk();
}
?>