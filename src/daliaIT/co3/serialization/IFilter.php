<?php
namespace daliaIT\co3\serialization;
/*/
interface IFilter
================================================================================
Implementing class can convert strings into structured arrays and vice versa.
The array must have the same structure as those used by the loader and dumper.
/*/
interface IFilter
{
    function in($data);
    function out($data);
}
?>