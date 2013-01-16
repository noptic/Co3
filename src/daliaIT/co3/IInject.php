<?php
namespace daliaIT\co3;
/*/ 
interface **IInject** extends IMake
================================================================================
 - authors:   Oliver Anan <oliver@ananit.de>
 - created:   2012/08/22
Required to craete class instnaces from arrays and vice versa.

Usage
--------------------------------------------------------------------------------
This interface is intended to be used for models. 
Data retived vie JSON or database querries can be turned into  objects without 
creating constructors for each model.
The integrity of the data must be ensured by the calling code 
 
All properties which are only used internaly (e.g. buffers amd file handles) 
should be private.

Using injectaion allows setting protected object properties when the object is 
created.

See
--------------------------------------------------------------------------------
 - sample: [Inject][com.daliaIT.co3.Inject]
 - White Paper: [Using Injection][doc: Injection.txt]
/*/
interface IInject
{    
    /*/
    public static object **inject(array $properties)**
    ============================================================================
    Creates a new  instance and injects the properties from an array.    
    The property namae is used as array key, Any renaming or maping nad 
    validation must be handled b y the calling code

    Implemantation
    ----------------------------------------------------------------------------
     - Implementing classes should *not* allow injecting *unknown properties*
     - *Private* properties should *not* be injected
     - * Always* return an instance of the *class* which was *called*.
     

    Parameters
    ----------------------------------------------------------------------------
     - `array $properties` Associative array containig the desired properties.
     
    Returns
    ----------------------------------------------------------------------------
    `IInject` instance of the called class     
    /*/
    static function inject($properties);
    
    /*/
    public static object[] **inject(array $properties)**
    ============================================================================
    Creates multiple instances and injects 
    Every member of the array must be an array of properties.
    
    Implemantation
    ----------------------------------------------------------------------------
     - keys must be preserved
     - Always return instances of the called class
     
    Parameters
    ----------------------------------------------------------------------------
     - `array $properties` Associative array containing arrays which will be 
        injected.
     
    Returns
    ----------------------------------------------------------------------------
    `IInject[]` instances of the called class 
    /*/
    static function injectMany($propertiesArray);
    
    /*/
    public static array **extract()**
    ============================================================================
    Returns an objects properties as array.
    The property namae is used as array key.
    
    Implementation
    ----------------------------------------------------------------------------
     - this should not return private properties
     - must not return properties which are not defined for thie objects class
     
     Returns
     ---------------------------------------------------------------------------
     `array` An associative array containing the objects properties
    /*/
    function extract();

}
?>