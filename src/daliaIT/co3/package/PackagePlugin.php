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
        LOAD_RESOURCE = 2,
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
    
    #:this
    public function loadPackage($name, $packageDir, Package $package, $options = 255){
        if( isset($this->loadedPackages[$name]) ){
            $options = $this->mergePackageOptions($name, $package, $options);
        } else {
            $this->loadedPackages[$name] = $package;
            $this->packageOptions[$name] = $options;
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
        $tryedPath = array();
        foreach(ArrayGenerator::mk(array(
                'src' => $this->packageSrc,
                'fileName' => array('package'),
                'fileType' => array_keys($this->encoding)
            )) as $tup){
            $path = "{$tup['src']}/$name/{$tup['fileName']}.{$tup['fileType']}";
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
                
            } else {
                $tryedPath[] = $path;
            }
        }
        throw new OutOfRangeException(
            implode("\n",array(
                "Unknown Package: '$name'",
                "Searched files:",
                implode("\n",$tryedPath)."\n"    
            ))    
        );
    }
    
    #:return int 
    protected function mergePackageOptions($name,Package $package, $options){
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
    protected function addFileSource($src){
        $this->core->IO->file->addSource( $src );
        return $this;
    }
}