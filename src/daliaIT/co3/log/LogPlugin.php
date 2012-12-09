<?php
namespace daliaIT\co3\log;
use Logger,
    DaliaIT\co3\Plugin;
class LogPlugin extends Plugin{
    protected
    #:string
        $format,
    #:Logger
        $logger;
    
    protected static 
    #:bool
        $logConfigured = false;
    
    private
    #:resource
        $logFileHandle;
    
    public function init($name){
        if($this->core->getConfValue('flag/log')
            && !static::$logConfigured
        ){
            Logger::configure($this->core->getConfValue('log'));    
        }
        $this->logger = Logger::getLogger('default');
        return $this;
    }
    
    public function out($text, $messageType='info'){
        if(! $this->core->getConfValue('flag/log')){
            return $this;
        }
        //if(! is_string($text)){
        //    $text = print_r($text, true);
        //}
        if( array_search($messageType, array(
            'trace', 'debug', 'info', 'warn', 'error', 'fatal'
        )) === false){
            throw new OutOfRangeException(
                $this->formatArgs(
                    __CLASS__.'/InvalidMessageType.txt', 
                    $messageType
                )
            );
        } 
        $this->logger->$messageType($text);    
    }
    
    public function trace($text){
        $this->out($text, 'trace');
    }
    
    public function debug($text){
        $this->out($text, 'debug');
    }
    
    public function info($text){
        $this->out($text, 'info');
    }
    
    public function warn($text){
        $this->out($text, 'warn');
    }
    
    public function error($text){
        $this->out($text, 'error');
    }
    
    public function fatal($text){
        $this->out($text, 'fatal');
    }
}