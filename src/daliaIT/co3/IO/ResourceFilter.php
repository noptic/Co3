<?php
namespace daliaIT\co3\IO;
use UnexpectedValueException;
class ResourceFilter extends Filter
{
    protected
    #:bool
        $isOutFilter = true;
    
    public function in($path){
        $data = $this->core->IO->file->in($path);
        $extension = $this->getFileExtension($path);
        if(! $extension) return $data;
        $encoding = $this->core->getConfValue("encoding/$extension");
        if(! $encoding){
            throw new UnexpectedValueException(
                $this->formatArgs(
                    'daliaIT/co3/IO/UnkownFileExtension.txt',
                    $extension
                )
            );
        }
        return $this->core->IO->in($data, $encoding);
    }
    
    protected function getFileExtension($path){
        $matches = array();
        preg_match('/\\.(\w+)$/', $path, $matches);
        if(! $matches){
            return '';
        } else return $matches[1];
    }
}