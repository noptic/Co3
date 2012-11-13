<?php
/*/
class daliaIT\co3\package\PackagePlugin extends daliaIT\co3\Plugin
================================================================================
Loads co3 packages at runtime
/*/
namespace daliaIT\co3\package;
use Exception,
    OutOfRangeException,
    daliaIT\co3\Plugin,
    daliaIT\CoLoad\CoLoad,
    daliaIT\co3\util\generator\ArrayGenerator;
    
class PackagePlugin extends Plugin{
    
    const
    #>type int
        LOAD_CLASS = 1,
        LOAD_RESOURCE = 2,
        #LOAD_PLUGINS = 4,
        LOAD_DEPENDENCIES = 8,
        LOAD_INCLUDES = 16,
        LOAD_ALL = 255;
        #<
    
    protected
    #>type string[]
        $packageSrc = array(),
        $encoding = array(),
        $loadedPackages = array(),
        $packageOptions =array();
        #<
    
    #:return this
    public function loadPackage($name, $packageDir, Package $package, $options = 255){
        if( $this->core->getConfValue('flag/debug')){
            echo "DEBUG: ".__METHOD__." package: ".$name."\n";
        }
        if( isset($this->loadedPackages[$name]) ){
            $options = $this->mergePackageOptions($name, $package, $options);
        } else {
            $this->loadedPackages[$name] = $package;
            $this->packageOptions[$name] = $options;
        }
 
        if( ($options & self::LOAD_CLASS) && $package->getSrc()  ){
            $this->addClassSource( $packageDir.'/'.$package->getSrc() );
        } 
        if( ($options & self::LOAD_RESOURCE) && $package->getResource() ){
            
            $this->addFileSource( $packageDir.'/'.$package->getResource() );
        }
        if( ($options & self::LOAD_INCLUDES) && $package->getIncludes() ){        
            foreach($package->getIncludes() as $inc){
                require_once $packageDir.'/'.$inc;    
            }
        }
        if( ($options & self::LOAD_DEPENDENCIES) && $package->getDependencies() ){          
            foreach($package->getDependencies() as $dep){
                if(! $this->packageLoaded($dep)){
                    try{
                        $this->in($dep);
                    }
                    catch(Exception $e){
                        throw new Exception(
                            "Loading the dependency '$dep' for package '$name' failed.",
                            0,
                            $e
                        );
                    }
                }
            }
        }
        #if( ($options & self::LOAD_PLUGINS) && $package->getPlugins() ){
        #    foreach($package->getPlugins() as $name => $class){
        #        $this->core->setPlugin($name, new $class());
        #    }
        #}
        return $this;
    }
    
    #:bool
    public function packageLoaded($name){
        return isset($this->loadedPackages[$name]);
    }
    
    #:Package
    public function getPackage($name){
        if( $this->packageLoaded( $name ) ){
            return $this->loadedPackages[$name];
        } else {
            throw new  OutOfRangeException(
                "Unkown Package '$name'"
                ." Loaded packages: ".implode(',',array_keys($this->loadedPackages))
            );
        }
    }
    
    #:Package
    public function getPackages(){
        return $this->loadedPackages;
    }
    
    #:this
    public function in($name, $options=255){
        foreach(ArrayGenerator::mk(array(
                'src' => $this->packageSrc,
                'fileType' => array_keys($this->encoding)
            )) as $tup){
            $path = implode(
                '/',
                array($tup['src'], $name, $tup['fileType'])
            );
            if (file_exists($path)){
                $package = $this->core->IO->in(
                    file_get_contents($path),
                    $this->encoding[$tup['fileType']]
                );
                if($package instanceof Package){
                    return $this->loadPackage(
                        $name, dirname($path),$package, $options
                    );
                }
                
            }
        }
        throw new OutOfRangeException(
            "Unknown Package: '$name'"    
        );
    }
    
    #:return int 
    protected function mergePackageOption($name,Package $package, $options){
        if($package->getId() != 
            $this->loadedPackages[$name]->getId() ){
            throw new Exception(
                "Package loading colusion. Name:'$name'\n"
                ."loaded package id: '"
                .$this->loadedPackages[$name]->getID()
                ."'\n new package id: '"
                -$package->getID()
                ."'\n"
            );
        }
        $oldOptions = $this->packageOptions[$name];
        $this->packageOptions[$name] = $options  | $$oldOptions;
        $options = $options & ~$oldOptions;
        return $options;
    }
    
    #:return this
    protected function addClassSource($src){
        $this->core->loader->getLoader('main')->addSource($src);
        return $this;
    }
    
    #:return this
    protected function addFileSource($src){
        if( $this->core->getConfValue('flag/debug')){
            echo "DEBUG: ".__METHOD__." src: ".$src."\n";
        }
        $this
            ->core
            ->IO
            ->getFilter('file')
            ->addSource( $src );
        return $this;
    }
}