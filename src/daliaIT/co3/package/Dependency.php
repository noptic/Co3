<?php
namespace daliaIT\co3\package;
use daliaIT\co3\Inject;
class Dependency extends Inject
{
    protected
    #>string
        $packageName,
        #<
    #>daliaIT\co3\bet\link[]
        $links = array();
        #<
    #>int
        $loadOptions;
        #<
        
    #:string
    public function getPackageName(){
        return $this->packageName();
    }
    
    #:daliaIT\co3\bet\link[]
    public function getLinks(){
        return $this->links;
    }
    
    #:int
    public function getLoadOptions(){
        return $this->loadOptions;
    }
}