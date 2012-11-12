<?php
/*/
 interface daliaIT\co3\IPlugin
================================================================================
 
   Tag            | Value                            
  ----------------|----------------------------------
   author         | Oliver Anan <oliver@ananit.de>   
   since          | Co3 0.3                      
   version        | v0.1.0.0 2012/09/26              
   license        | LGPL3 <http://www.gnu.org/licenses/lgpl-3.0.en.html> 

 Defines the required logic to ind a plugin to the core.
 
Usage
--------------------------------------------------------------------------------
 All co3 plugins must implement this interface.
 
/*/
namespace daliaIT\co3;
interface IPlugin {
    function setCore(Core $core);
    function getCore();
    function init($name);
}