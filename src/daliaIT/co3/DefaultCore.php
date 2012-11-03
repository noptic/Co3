<?php
namespace daliaIT\co3;
use daliaIT\CoLoad\CoLoad,
    daliaIT\co3\loader\LoaderPlugin,
    daliaIT\co3\IO\IOPlugin,
    daliaIT\co3\IO\Loader,
    daliaIT\co3\IO\VNHFilter,
    daliaIT\co3\IO\FileFilter,
    daliaIT\co3\IO\PHPFilter,
    daliaIT\co3\IO\YAMLFilter,
    daliaIT\co3\IO\JSONFilter,
    daliaIT\co3\package\PackagePlugin;
    
class DefaultCore extends Core{
    public function boot($conf){
        $this->conf = $conf;
        $this->setPlugin('loader',$this->createLoaderPlugin());        
        $this->setPlugin( 'IO', $this->createIOPlugin() );
        $this->setPlugin( 'package', $this->createPackagePlugin() );
        $this->loadPlugins();
    }
    
    protected function createLoaderPlugin(){
        $loader = new CoLoad(
            $this->conf['path']['tmp'].'/classMap.json',
            array($this->conf['path']['source'])
        );
        $loader->register();
        return LoaderPlugin::inject(array(
            'loaders' => array( 'main' => $loader)
        ));
    }
    
    protected function createTypeMap(){
        $typeMap = $this->conf['types'];
        array_walk(
            $typeMap,
            function($element){
                if( isset($element['converter']) ){
                    $converterClass = $element['converter'];
                    $element['converter'] = $converterClass::mk();
                }
                return $element;
            }
        );
        return $typeMap;
    }
    
    protected function createIOPlugin(){
        return  IOPlugin::inject(array(
            'filters' => array(
                'php'   => new PHPFilter(),
                'yaml'  => new YAMLFilter(),
                'json'  => new JSONFilter(),
                'file'  => FileFilter::inject(array(
                    'sources' => array($this->conf['path']['resource'])
                )),
                'vnh'   => VNHFilter::inject(array(
                    'typeDefinitions' => $this->createTypeMap(), 
                    'loader' => new Loader()
                ))
            )
        ));    
    } 
    
    protected function createPackagePlugin(){
        return PackagePlugin::inject(array(
            'loadedPackages' => array('co3' => $this->getOwnPackage()),
            'packageOptions' => array('co3'=> PackagePlugin::LOAD_ALL),
            'packageSrc'     => array($this->conf['path']['package'])
        ));
    }
    protected function getOwnPackage(){
        return $this->IO->in(
            file_get_contents($this->conf['package']['location']),
            $this->conf['package']['filter']
        );
    }
    
    protected function loadPlugins(){
        foreach(
            $this->package->getPackage('co3')->getPlugins()
            as $name => $pluginClass
        ) {
            if(! $this->pluginExists($name)){
                $this->setPlugin($name, new $pluginClass);
            }
        }
    }
    
}