<?php
require __DIR__.'/external/spyc/spyc.php';
$core = null;
if(! isset($co3Config) ){
    $co3Config = array();
}
call_user_func(
function(){
    global
        $co3Config,
        $core;
    //load conf
    $spyc = new Spyc();
    $configFile = __DIR__.'/conf.yaml';
    if(! is_readable($configFile)){
        throw new Exception(
            "co3 Bootstrap error: "
            ."Missing system file '{$confFile}'"
        );
    }
    $conf = $spyc->load( file_get_contents($configFile), true );
    if( $conf === null) throw new Exception(
            "co3 Bootstrap error: "
            ."Parsing config file failed: '{$configFile}'"
    );
    $localConfigFile = dirname($_SERVER['SCRIPT_FILENAME'])."/conf.yaml";
    if(is_readable($localConfigFile)){
        $localConfig = $spyc->load( file_get_contents($localConfigFile), true );
        if( $localConfig === null) throw new Exception(
            "co3 Bootstrap error: "
            ."Parsing local config file failed: '{$localConfigFile}'"
        );
        $conf = array_replace_recursive( $conf, $localConfig ); 
    }
    $conf = array_replace_recursive(
        $conf,
        $co3Config
    );

    array_walk_recursive(
        $conf,
        function(&$val, $key, $vars){
            $val = str_replace(
                array_keys($vars),
                $vars,
                $val
            );
        },
        array( 
            '#BOOT#'        => __FILE__,
            '#BOOT_DIR#'    => __DIR__,
            '#CONFIG#'      => $configFile,
            '#CONFIG_DIR#'  => dirname($configFile),
            '#SCRIPT#'      => $_SERVER['SCRIPT_FILENAME'],
            '#SCRIPT_DIR#'  => dirname($_SERVER['SCRIPT_FILENAME']),
            '#SCRIPT_HASH#' => md5($_SERVER['SCRIPT_FILENAME']),
            '#PACKAGE_DIR#' => dirname(__DIR__)
        )
    );    
    foreach($conf['path'] as $dir){
        if(! file_exists($dir)){
            mkdir($dir, 0777, true);
        }
    }
    //require files
    if(isset($conf['require'])){
        foreach($conf['require'] as $required){
            require $required;
        }
    }
    
    //craete objects
    $exceptioMessage = "Co3 Bootstrap error: Missing core config key ";
    if(! isset($conf['core'])){
        throw new Exception($exceptioMessage.'core');
    }
    if(! isset($conf['core']['class'])){
        throw new Exception($exceptionMessage.'core/class');
    }
    $class = $conf['core']['class'];
    $args = isset( $conf['core']['args'] )
        ? $conf['core']['args']
        : false;            
    if($args){
        $reflection = new ReflectionClass($class);
        $core =  $reflection->newInstanceArgs($args);
    } else {
        $core = new $class();
    }
    //DFTBA
    $core->boot($conf);
});