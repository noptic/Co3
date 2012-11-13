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
        $filters;

    public function hasFilter($name){
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
            if(! $this->hasFilter($filter)){
                throw new OutOfRangeException(
                    "Unkown filter: '$filter'. Registered filters: "
                    .implode(', ', array_keys($this->filters) )
                );
            }
            return $this->filters[$filter];
        }
    }
    
    public function getFilters(){
        return $this->filters;    
    }
    
    public function setFilter($name, IFilter $filter){
        if($this->getCore !== null){
            $filter->setCore($this->getCore()); 
        }
        $this->filters[$name] = $filter;
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
    
    public function setCore(Core $core){
        parent::setCore($core);
        foreach($this->filters as $filter){
            $filter->setCore($core);
        }
        return $this;
    }
    
    
}