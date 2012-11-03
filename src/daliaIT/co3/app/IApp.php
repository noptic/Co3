<?php
namespace daliaIT\co3\app;
use Exception,
    daliaIT\co3\Core;
interface IApp
{
    function boot(Core $core);
    function run();
    function fail(Exception $e);
    function shutdown(); 
    
    function getCore();
    function getOnBoot();
    function getOnRun();
    function getOnFail();
    function getOnShutdown();
}
?>