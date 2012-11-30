<?php
/*/
author:     Oliver Anan <oliver@ananit.de>
versiom:    [0.1.1.1]
package:    co3

================================================================================
interface IFilter
================================================================================
 
Manipulate data, input and output types depend on the implementing filter.

implementation
--------------------------------------------------------------------------------
If a filter converts external data in a PHP native format the 'in' methid should
return the PHP native format and the out method the external format.

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
namespace daliaIT\co3\IO;
use daliaIT\co3\ICoreUser;
interface IFilter extends ICoreUser
{
    function in($data);
    function out($data);
    function getIsInFilter();
    function getIsOutFilter();
    
}
?>