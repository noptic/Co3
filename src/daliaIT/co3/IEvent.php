<?php
namespace daliaIT\co3;
use Closure;
interface IEvent
{
    function bind(Closure $callback);
    function unbind(Closure $callback);
    function trigger($data);
    function getHandle();
    function getOwner();
}
?>