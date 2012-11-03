<?php
namespace daliaIT\co3\IO;
/*/
interface IFilter
================================================================================

 Ke         | Vakue
 -----------|---------------------------------
 Author     | Oliver Anan \oliver@ananit.de
 Version    | 0.1.1
 Package    | co3
 
Manipulate data, input and output types depend on the implementing filter.

implementation
--------------------------------------------------------------------------------
If a filter converts external data in a PHP native format the 'in' methid should
return the PHP native format and the out method the external method.

The array must have the same structure as those used by the loader and dumper.
The methods getIsInFilter(), getIsOutFilter() must return a boolean value
indicating if the instance can be used to import or export data.

Remarks:

 - filters are not typed
 - filters may change the data
 - the classification as in or out filter may be different for multiple 
   instances of the same Filter class.
   
Source
--------------------------------------------------------------------------------
/*/
interface IFilter
{
    function in($data);
    function out($data);
    function getIsInFilter();
    function getIsOutFilter();
    
}
?>