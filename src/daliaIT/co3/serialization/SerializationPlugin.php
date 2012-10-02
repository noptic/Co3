<?php
namespace daliaIT\co3\serialization;
use Exception,
    OutOfRangeException,
    daliaIT\co3\Plugin;

class SerializationPlugin extends Plugin
{
    protected 
        $filters,
        $loader,
        $dumper;
    
    public function hasFilter($name){
        return isset($this->filters[$name]);
    }
    
    public function getFilter($filter){
        if($filter instanceof IFilter){
            return $filter;
        } else {
            if(! $this->hasFilter($filter)){
                throw new OutOfRangeException("Unkown filter: '$filter'");
            }
            return $this->filters[$filter];
        }
    }
    
    public function setFilter($name, IFilter $filter){
        $this->filters[$name] = $filter;
    }
    
    public function import($data, $filters=null){
        if($filters !== null){
            if(! is_array($filters)){
                $filters = explode('/',$filters);
            }
            foreach($filters as $filter){
                $data = $this
                    ->getFilter($filter)
                    ->in($data);
            }
        }
        
        if($this->loader === null){
            throw new Exception("No object loader defined");
        }
        return $this->loader->load($data);
    }
    
    public function export($data, $filters=null){
        if($this->dumper === null){
           throw new Exception("No object dumper defined");
        }
        $data = $this->dumper->dump($data);      
        if($filters !== null){
            if(is_array($filters)){
                $filters = explode('/',$filters);
            }
            foreach($filters as $filter){
                $data = $this
                    ->getFilter($filter)
                    ->out($data);
            }
        }
        return $data;
    }
    
    public function convert($data, $importFilter, $exportFilter){
        return $this
            ->export( $this->import($data, $importFilter), $exportFilter );
    }
}