<?php
namespace daliaIT\co3\test;
use Exception,
    daliaIT\co3\app\App;
    
class BootTest extends App
{
    public function run($args=array()){
        if($this->core == null) throw new Exception(
            'No core found'  
        );
        
        foreach(array('IO','app','package') as $vitalPlugin){
            if(! $this->core->pluginExists($vitalPlugin) ){ 
                throw new Exception(
                    "Missing vital plugin: '$vitalPlugin'"
                );
            }
        }
        return true;
    }
    
}