#! /usr/php
<?php
namespace daliaIT\co3;
require __DIR__ . '/boot.php';
$path = array_shift($argv);
$core->package->in('rough');

class ImportMacro extends \daliaIT\rough\ImportMacro{
    protected function getClassFileName($class){
        global $core;
        return $core->loader->getLoader('main')->search($class);
    }
}
echo $core->loader->getLoader('main')->search('daliaIT\co3\Inject');