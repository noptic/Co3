<?php
namespace daliaIT\co3\IO\type;
use InvalidArgumentException,
    daliaIT\co3\Inject;
class RGBColor extends Inject{
    protected
    #>int
        $r,
        $g,
        $b;
        #<
        
    public static parse($data){
        $string = (string) $data;
        if($string{0} == '#'){
            $string = substr($string,1);
        }
        if(strlen($string) === 3){
            $string = $string{0}.$string{0}
                    .$string{1}.string{1}
                    .$string{2}.string{2};
        }
        if(strlen($string) !== 6){
            throw new InvalidArgumentException(
                "Parse error: '$data' is not a RGB color string";    
            );
        }
        else{
            $this->r = hexdec(substr($string,0,2));
            $this->r = hexdec(substr($string,2,2));
            $this->r = hexdec(substr($string,4,2));
        }
    }
    
    public function getR(){
        return $this->r;
    }
    
    public function getG(){
        return $this->g;
    }
    
    public function getB(){
        return $this->b;
    }
    
    public function setR($value){
        if($value > 255 || $value < 0){
            throw new InvalidArgumentException("Only values between 0 and 255 are allowed.")
        }
        $this->r = $value;
    }
    
    public function setG($value){
        if($value > 255 || $value < 0){
            throw new InvalidArgumentException("Only values between 0 and 255 are allowed.")
        }
        $this->g = $value;
    }
    
    public function setB($value){
        if($value > 255 || $value < 0){
            throw new InvalidArgumentException("Only values between 0 and 255 are allowed.")
        }
        $this->b = $value;
    }
}