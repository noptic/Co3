<?php
namespace daliaIT\co3\test;
use Exception,
    daliaIT\co3\app\App;
    
class ClassResourceTest extends App
{
    public function run($args=array()){
        if(! $this->core->IO->file->search('daliaIT/co3/test/ClassResourceTest/sample.txt') ){
            $ioData = $this->core->IO->file->extract();
            throw new Exception(implode("\n",array(
                "can not load sample resource",
                "path: 'daliaIT/co3/test/ClassResourceTest/sample.txt'",
                "sources: ".var_export($ioData['sources'],true)
            )));
        }
        $viaIO = $this->core->IO->file->in(
            'daliaIT/co3/test/ClassResourceTest/sample.txt',
            'file'
        );
        $viaResource = parent::getResource('sample.txt',__CLASS__);die();
        if(viaResource !== $viaIO){
            throw new Exception(implode("\n",array(
                "class resource loading failed",
                "via IO: $viaIO",
                "via Resource: $viaResource"
            )));
        }
    }
    
}