<?php
/*/
interface daliaIT\co3\hydra\ITypedProperties
================================================================================
Provides Type informations about class properties.  

Usage
--------------------------------------------------------------------------------
PHP is not type strict but some tools require type informations about a objects 
properties. 

This interface is intendsed for generated model classes, data validation and 
converting arrays to objects.

Implementation
--------------------------------------------------------------------------------
When extending a class which implements this interface type information for
all new properties must be provided.   

Methods
--------------------------------------------------------------------------------
### static daliaIT\co3\hydra\type getStrictReflectionProperty(string $propertyName);
/*/
namespace daliaIT\co3\hydra;
interface ITypedProperties
{
    static function getStrictReflectionProperty( $propertyName ); 
}



