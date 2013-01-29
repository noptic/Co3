<?php
/*/
type:       class
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    [0,1,0,0]
tags:       [system core]
================================================================================
DefaultCore
================================================================================
A core with some essintial plugins already set.

The default co3config will use this core.

List of preset pluins:
--------------------------------------------------------------------------------
IO:         daliaIT\co3\IO\IOPlugin
package:    daliaIT\co3\package\PackagePlugin

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3;
use Spyc,
    Exception,
    OutOfRangeException,
    UnexpectedValueException,
    Symfony\Component\Yaml\Parser,
    daliaIT\co3\IO\IOPlugin,
    daliaIT\co3\IO\FileFilter,
    daliaIT\co3\IO\ResourceFilter,
    daliaIT\co3\IO\YAMLFilter,
    daliaIT\co3\IO\VNHFilter,
    daliaIT\co3\package\Package,
    daliaIT\co3\package\PackagePlugin;
    
class DefaultCore extends Core{
    #:this
    public function boot($conf){
        parent::boot($conf);
        $parser = new Parser();
        $rawPackage = $parser->parse(
            file_get_contents($this->conf['package']['location'])
        );
        $rawPackage = $rawPackage['value'];        
        $this
            ->createIOPlugin($rawPackage)
            ->createPackagePlugin($rawPackage)
            ->loadDependencies();
    }
    
    #:this
    protected function createIOPlugin($rawPackage){
        $this->setPlugin( 'IO', IOPlugin::mk()
            ->setFilter('file', new FileFilter() )
            ->setFilter('resource', new ResourceFilter() )
            ->setFilter('yaml', new YAMLFilter() )
            ->setFilter('vnh', new VNHFilter() )
        );
        return $this;
    } 
    
    #:this
    protected function createPackagePlugin($rawPackage){
        $plugin = PackagePlugin::inject(array(
            'packageOptions'    => array('co3'=> PackagePlugin::LOAD_ALL),
            'packageSrc'        => array( $this->getConfValue('path/package') ),
            'encoding'          => $this->getConfValue('encoding')
        ));
        $this->setPlugin('package',$plugin);
        $package = Package::inject($rawPackage);
        
        $plugin->loadPackage(
            'co3', 
            $this->getConfValue('path/co3dir'), 
            $package
        );
        return $this;
    }
    
    #:this
    protected function loadDependencies(){
        $dependecies = $this->getConfValue('dependency');
        if(! $dependecies) return $this;
        foreach($dependecies as $dependency){
            $this->package->in($dependency);
        }
        return $this;
    }
    
    #:bool
    public function pluginExists( $name, $autoLoad=true ){
        if(isset($this->plugins[$name])){
            return true;
        } elseif(isset($this->plugins['package']) && $autoLoad){
            return (bool) $this->package->searchPlugin($name);
        } else {
            return false;
        }
    }
    
    #:IPlugin
    public function getPlugin($name){
        if( !$this->pluginExists( $name, false ) ){
            $plugin = $this->IO->resource->in("plugin/$name.plugin.yvnh");
            if(! $plugin instanceof IPlugin){
                $type = (is_object($plugin))
                    ? get_class($plugin)
                    : gettype($plugin);
                throw new UnexpectedValueException(
                    $this->IO->formatArgs(
                        'format/daliaIT/co3/WrongType.txt',
                        'Plugin',
                        'daliaIT\\co3\\IPlugin',
                        $type
                    )
                );
            }
            $this->setPlugin( 
                $name,  $plugin
            );
        }
        return $this->plugins[$name];
    }
}