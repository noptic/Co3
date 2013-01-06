<?php
namespace daliaIT\co3\h2o;
use H2o,
    daliaIT\co3\Plugin;
    
class H2oPlugin extends Plugin{
    protected
    #:mixed[]
        $options = array();
        
    public function out($template, array $args){
        $h2o = new H2o($template, $this->options);
        $h2o->render($args);
    }
    
    public function getOptions(){
        return $this->options;
    }
    
    public function setOptions(array $options){
        $this->options = $options;
    }
}