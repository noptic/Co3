<?php
/*/
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    0.1.2
package:    co3

================================================================================
class daliaIT\co3\IO\FileFilter extends Filter
================================================================================
Searches and loads a file from a list of directorys.
This is s 'in' filter, *exporting data is NOT supported* and will throw an error
Methods
--------------------------------------------------------------------------------

### FileFilter addSource(string $path)
Add a source directory.

### string in($path)
Expects an relative file path and return the contents of the file as string.

All leading and trailing whitespace and slashes will be removed.

The file will be searched in all registered source directories.

While searching in subdirectories is supported the filter will not allow
accessing the parent directories of the registered sources. 

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\IO;
use InvalidArgumentException;

class FileFilter extends Filter
{
    protected
        #:string[]
        $sources = array(),
        #:bool
        $isOutFilter = false;
    
    #:this
    public function addSource($source){
        #if (array_search($source, $this->sources) !== false){
            $this->sources[] = $source;
        #}
        return $this;
    }
    
    #:string
    public function in($relativePath){
        $path = $this->search($relativePath);
        if($path === null){
            throw new InvalidArgumentException(implode("\n",array(
                "Can not read file '$relativePath",
                "Sources:",
                implode("\n",$this->sources)
            )));
        }
        return file_get_contents($path);            
    }
    #:string
    public function search($string){
        $string = $this->normalize($string);
        $log = $this->core->pluginExists('log');
        foreach($this->sources as $source){
           $path = "$source/$string";
           if($log){
                $this->core->log->debug(
                    __METHOD__."($string) try path: \"$path\""
                );
           }
           if(is_readable($path)){
                if($log){
                    $this->core->log->debug(
                        __METHOD__."($string) found: \"$path\""
                    );
               }
                return $path;    
            }
            if($log){
                $this->core->log->debug(
                    __METHOD__."($string) not found: \"$path\""
                );
            }
        }
        return null;
    }
    
    #:string
    public function normalize($string){
        $rawParts = explode('/',$string);
        $finalParts = array();
        foreach($rawParts as $part){
            switch($part){
                case '':
                case '.':
                    break;
                case'..':
                    if(count($finalParts)){
                        array_pop($finalParts);    
                    } else {
                        throw new InvalidArgumentException(
                            "Can not resolve the path '$string'."
                            ."Access to the parent directory is prohibited"
                        );
                    }
                    break;
                default:
                    $finalParts[] = $part;
            }
        }
        return implode('/',$finalParts);
    }
}