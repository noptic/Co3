<?php
/*/
 class daliaIT\co3\Plugin
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

 Methods
--------------------------------------------------------------------------------
### IPlugin setCore(Core $core)
Binds the plugin to a core and is intended for internal use only.

### ICore getCore()
returns the core the plugin is bound to.

 Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3;
use ReflectionProperty;

abstract class Plugin extends CoreUser implements IPlugin
{    
       
    protected 
        $core;
    
    public function init( $name ){
        
    }
}

