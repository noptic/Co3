<?php
namespace daliaIT\co3\test;
use daliaIT\Plugin;

class ClassTestCompiler{
    protected
    #:string
        $bootScript,
    #:bool
        $useOpenTag = false;
    
    public function out(
        ClassTest $classTest,
        $className      = 'TEST____CLASS', 
        $methodName     = 'TEST____METHOD',
        $format   = 'format/daliaIT/co3/test/TestClass.txt'
    ){
        $scripts = array();
        foreach($classTest->getMethodTests() as $methodTest){
            $scripts[] = $this->compileMethodTest(
                $this, 
                $methodTest,
                $className,
                $methodName,
                $format
            );
        }
    }
    
    protected function compileMethodTest( 
        ClassTest $classTest,
        MethodTest $metthodTest,
        $className, 
        $methodName,
        $format
    ){
        $steps = var_export($methodTest->getSteps(),true);
        
        $autoloader = $this->createAutoloader(array_replace(
            $classTest->getMocks(), 
            $methodTest->getMocks()
        ));
        
        $constants = $this->creatConstantDefinitions(array_replace(
            $classTest->getConstants(), 
            $methodTest->getConstants()
        ));
        
        $script = $core->IO->formatArgs(
            $format,
            $className,
            $methodName,
            $steps,
            $autoloader . $constants,
            $this->bootScript
        );
    }
    
    protected function createAutoloader(array $mocks){
        return $this->formatArgs(
            'format/daliaIT/co3/test/MockAutoloader.txt',
            var_export($test->getMocks(),true)
        );
    }
    
    protected function creatConstantDefinitions(array $constants){
        $definitions = '';
        foreach($constants as $name => $value){
            $definitions = "define('$name',".var_export($value, true).');';
        }
        return $definitions;
    }
}
?>