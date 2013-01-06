<?php
/*/
author:
  name:     Oliver Anan
  mail:     <oliver@ananit.de>
version:    0.1.2
package:    co3

================================================================================
class daliaIT\co3\IO\TempFileFilter extends Filter
================================================================================
Works like a FileFilter but stores the data in temp files.


You can use inject to create temp files at object creation with the key `files`.
The value of `files`must be an array where the key is the filename and the value
the contents.

Using search will return the path to the temp file.

Methods
--------------------------------------------------------------------------------

### setFileContents($path, $data)
Adds or updates a file. The file can then be accessed via the virtual path

### string in($path)
Expects an virtual path and return the contents of the file as string.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\IO;
use InvalidArgumentException;

class TempFileFilter extends FileFilter
{
    protected
    #:string[]
        $files = array();
        
    
    #:string
    public function search($path){ 
        if( isset($this->files[$path]) ){
            return $this->files[$path];
        }
        return null;
    }
    
    protected function postInject(){
        $tmpFiles= array();
        foreach( $this->files as $key => $value){
            $tmpFile = tempnam(spl_object_hash($this),'v_');
            file_put_contents($tmpFile, $value);
            $tmpFiles[$key] = $tmpFile;
        }
        $this->files = $tmpFiles;
    }
}