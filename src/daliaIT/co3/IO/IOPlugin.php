<?php
/*/
class  daliaIT\co3\IO\IOPlugin extends daliaIT\co3\Plugin
=================================================================================


/*/
namespace daliaIT\co3\IO;
use Exception,
    OutOfRangeException,
    InvalidArgumentException,
    daliaIT\co3\Core,
    daliaIT\co3\Plugin;

class IOPlugin extends Plugin
{
    protected 
        $filters = array();

    public function hasFilter($name, $autoLoad=true){
        return isset($this->filters[$name]);
    }
    
    public function getFilter($filter){
        if(! $filter){
            $filterDump = print_r($filter, true);
            throw new InvalidArgumentException(
                "'$filterDump' is not a valid filter name"
            );
        }
        if($filter instanceof IFilter){
            return $filter;
        } else {
            if(! $this->hasFilter($filter, false)){
                if(! isset($this->filters['resource'])){
                    throw new Exception(
                        "Can not autoload filter '$filter'. No resource filter set."
                        ."You must set a resource filter to" 
                        ."autoload other filters."
                    );
                }
                $newFilter = $this->in(
                    "filter/$filter.filter.yvnh",
                    "resource"
                );
                if(! $newFilter){
                    throw new InvalidArgumentException(sprintf(
                        "filter '%s' could not be found.",
                        print_r($filter,true)
                    )); 
                }
                $this->setFilter($filter, $newFilter);
            }
            return $this->filters[$filter];
        }
    }
    
    public function filterExists($name, $autoLoad=true){
        return isset($this->filters[$name]);
    }
    
    public function setFilter($name, IFilter $filter){
        if($this->getCore() !== null){
            $filter->setCore($this->getCore()); 
        }
        $this->filters[$name] = $filter;
        return $this;
    }
    
    public function in($data, $filters=null){
        if($filters !== null){
             if(! is_array($filters)){
                if(is_string($filters)){
                    $filters = explode('|',$filters);    
                }
                else $filters = array($filters);
            }
            foreach($filters as $filter){
                if(is_string($filter)){
                    $filter = $this->getFilter($filter);
                }
                if(! $filter instanceof IFilter){
                    throw new InvalidArgumentException(sprintf(
                        "'%s' could not be resolved to a filter.",
                        print_r($filter,true)
                    ));
                }
                $data = $filter->in($data);
            }
        }
        return $data;
    }
    
    public function out($data, $filters=null){
        if($filters !== null){
           if(! is_array($filters)){
                if(is_string($filters)){
                    $filters = explode('|',$filters);    
                }
                else $filters = array($filters);
           }
            foreach($filters as $filter){
                if(is_string($filter)){
                    $filter = $this->getFilter($filter);
                }
                if(! $filter instanceof IFilter){
                    throw new InvalidArgumentException(sprintf(
                        "'%s' could not be resolved to a filter.",
                        print_r($filter,true)
                    ));
                }
                $data = $filter->out($data);
            }
        }
        return $data;
    }
    
    public function convert($data, $importFilter, $exportFilter){
        return $this
            ->export( $this->import($data, $importFilter), $exportFilter );
    }
    
    public function __get($name){
        return $this->getFilter($name);
    }
    
    #@get public filters array#
    
    #:array
    public function getFilters(){
        return $this->filters;
    }
    #@#
}