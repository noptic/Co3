<?php
namespace daliaIT\co3;
interface IClassHasResource{
    function getResource($name, $class=null, $filter='file');
}