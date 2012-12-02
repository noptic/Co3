<?php
namespace daliaIT\co3\IO;
/*/
Author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
Version:    [0.0.1.0]
Package:    co3
================================================================================
class GlobFilter
================================================================================
Find pathnames matching a pattern.

This filter does not use the virtual resource file system.

Unliuke the glob function, this will
 - strip '.' and '..'
 - return only unique values
Source
--------------------------------------------------------------------------------
/*/
class GlobFilter extends Filter
{         
    protected
    #>bool
        $isInFilter = true,
        $isOutFilter = false;
        #<
        
    public function in($data){
        $results = glob($data);
        if(!$results) return array();
        foreach(array('.','..') as $removeThis){
            $key = array_search($removeThis, $results);
            if($key !== false){
                unset($results[$key]);
            }
        }

        if(!$results) return array();
        return array_unique($results);
    }
    
    public function recursive($filePattern, $base='', $dirPattern='*'){
        $files = array();
        foreach($this->in($base.$filePattern) as $file){
            if(!is_dir($file)) $files[] = $file;
        }
        foreach($this->in($base.'/'.$dirPattern) as $dir){
            if(is_dir($dir)){
                $results =$this->recursive($filePattern, $dir, $dirPattern);
                $files = array_merge($files,$results);
            }
        }
        return $files;
    }
}