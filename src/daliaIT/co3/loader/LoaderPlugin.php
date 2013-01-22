<?php
/*/
class daliaIT\co3\loader\LoaderPlugin extends daliaIT\co3\Plugin
================================================================================

   Tag            | Value                            
  ----------------|----------------------------------
   author         | Oliver Anan <oliver@ananit.de>   
   since          | co3 0.3                      
   version        | v0.1.0.0 2012/09/30              
   license        | LGPL3 <http://www.gnu.org/licenses/lgpl-3.0.en.html>  
   
 All used autoloaders should be added to autoloaders list.
 
 This is currently just a stub classes, but should be used anyway.
 Since a autoloader is already used to bootstrap co3, autoloaders should not
 depend on co3.
 
 Autoloaders are a vital part of the system so they should be accesible
 from ther core.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\loader;
use daliaIT\co3\Plugin;
class LoaderPlugin extends Plugin{
    protected
        $loaders = array();
    
    public function addLoader($name, $loader){
        $this->loaders[$name] = $loader;
    }
    
    public function getLoader($name){
        return $this->loaders[$name];
    }
    
    #@get public loaders array#
    
    #:array
    public function getLoaders(){
        return $this->loaders;
    }
    #@#
}
