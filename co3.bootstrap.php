<?php
/*/
co3.bootstrap
=================================================================================
Loads the core components required to use the co3 package.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3;
use Spyc,
    Exception,
    daliaIT\CoLoad\CoLoad,
    daliaIT\co3\loader\LoaderPlugin,
    daliaIT\co3\serialization\SerializationPlugin,
    daliaIT\co3\serialization\Loader,
    daliaIT\co3\serialization\Dumper,
    daliaIT\co3\serialization\FileFilter,
    daliaIT\co3\serialization\PHPFilter,
    daliaIT\co3\serialization\YAMLFilter,
    daliaIT\co3\serialization\JSONFilter;
    

$core;
call_user_func(
function(){
    global $core;
    //files
    $files = array(
        'package'   => 'package.yaml',
        'types'     => 'resource/daliaIT/co3/types.yaml',
        'resource'   => 'resource',
        'spyc'      => 'external/spyc/spyc.php',
        'autoloader'=> 'external/CoLoad/CoLoad.php',
        'classMap'  => 'tmp/classMap.json',
    );
    $requiredFiles = array('package','types','spyc','autoloader');
    
    array_walk(
        $files,
        function(&$path){ $path = __DIR__."/$path";}
    );
    foreach($requiredFiles as $requiredFile){
        if(! file_exists($files[$requiredFile])){
            throw new Exception(
                "co3 Bootstrap error: "
                ."Missing system file '{$files[$requiredFile]}'"
            );
        }
    }
    
    //load externals
    require_once $files['spyc'];
    require_once $files['autoloader'];
    
    //start system
    $rawPackage = Spyc::YAMLLoad($files['package']);
    $loader = new CoLoad($files['classMap']);
    $loader->addSource(
        __DIR__ . '/' . $rawPackage['properties']['src']['value']
    );
    $loader->register();
    $typeMap = spyc_load(file_get_contents($files['types'])); 
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
    $core = Core::mk()
        ->activate()
        ->setPlugin(
            'autoloader',
            LoaderPlugin::inject(array(
                'loaders' => array( 'main' => $loader)
            ))
        )
        ->setPlugin(
            'serialization',
            SerializationPlugin::inject(array(
                'loader' => Loader::inject(array(
                    'typeDefinitions' => $typeMap
                )),
                #TODO implement Dumper
                #'dumper' => Dumper::inject(array(
                #    'typeDefinitions' => $typeMap
                #)),
                'filters' => array(
                    'php'   => new PHPFilter(),
                    'yaml'  => new YAMLFilter(),
                    'json'  => new JSONFilter(),
                    'file'  => FileFilter::inject(array(
                        'sources' => array($files['resource'])
                    ))
                )
            ))
        );
 

    foreach(
        $core->serialization->import('daliaIT/co3/plugins.yaml','file/yaml')
        as $name => $plugin
    ) {
        $core->setPlugin($name, $plugin);
    }

});