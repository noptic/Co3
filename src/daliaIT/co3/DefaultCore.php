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
    daliaIT\co3\IO\typeFilter\FloatFilter,
    daliaIT\co3\IO\typeFilter\IntFilter,
    daliaIT\co3\IO\typeFilter\BoolFilter,
    daliaIT\co3\IO\typeFilter\StringFilter,
    daliaIT\co3\package\PackagePlugin;
    
class DefaultCore extends Core{
    public function boot($conf){
        $this->conf = $conf;
        $this->setPlugin('loader',$this->createLoaderPlugin());        
        $this->setPlugin( 'IO', $this->createIOPlugin() );
        $this->setPlugin( 'package', $this->createPackagePlugin() );
        $this
            ->loadDependencies()
            ->loadPlugins();
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
    
    protected function createIOPlugin(){
        return  IOPlugin::inject(array(
            'filters' => array(
                'float' => new FloatFilter(),
                'int'   => new IntFilter(),
                'bool'  => new BoolFilter(),
                'string'=> new StringFilter(),
                'php'   => new PHPFilter(),
                'yaml'  => new YAMLFilter(),
                'json'  => new JSONFilter(),
                'file'  => FileFilter::inject(array(
                    'sources'   => array($this->conf['path']['resource'])
                )),
                'vnh'       => VNHFilter::inject(array(
                    'loader'    => Loader::inject(array(
                        'core' => $this
                    ))
                ))
            )
        ));    
    } 
    
    protected function createPackagePlugin(){
        $data = $this->getConfValue('plugin/package');
        $class = $data['type'];
        $data = array_merge_recursive($data,array(
            'value' => array(
                'loadedPackages' => array('co3' => $this->getOwnPackage()),
                'packageOptions' => array('co3'=> PackagePlugin::LOAD_ALL)
            )     
        ));
        return $this->IO->in($data, 'vnh');
    }
    
    protected function getOwnPackage(){
        return $this->IO->in(
            file_get_contents($this->conf['package']['location']),
            $this->conf['package']['filter']
        );
    }
    
    protected function loadDependencies(){
        $dependecies = $this->getConfValue('dependency');
        if(! $dependecies) return $this;
        foreach($dependecies as $dependency){
            $this->package->in($dependency);
        }
        return $this;
    }
    protected function loadPlugins(){
        $pluginConf = $this->getConfValue('plugin');
        foreach($this->package->getPackages() as $package){
            foreach($package->getPlugins() as $name => $pluginClass){
                if($this->pluginExists($name)) continue;
                if(isset($pluginConf[$name])){
                    $this->setPlugin(
                        $name, 
                        $this->IO->in($pluginConf[$name], 'vnh')
                    );
                } else {
                    $this->setPlugin(
                        $name, 
                        new $pluginClass()
                    );
                }
            }
        }
        return $this;
    }
}