<?php
namespace daliaIT\co3\test;
use daliaIT\co3\CoreUser;

class ClassTestCompiler extends CoreUser{    
    public function out(
        ClassTest $classTest,
        $className      = 'TEST____CLASS', 
        $methodName     = 'TEST____METHOD',
        $format   = 'format/daliaIT/co3/test/TestClass.txt'
    ){
        $script = $this->createAutoloader($classTest->getMocks());
        foreach($classTest->getMethodTests()as $index => $methodTest){
            $script .= $this->compileMethodTest(
                $classTest, 
                $methodTest,
                $className.$index,
                $methodName.$index,
                $format,
                $classTest->getClass().', '.$index
            );
        }
        return $script;
    }
    
    protected function compileMethodTest( 
        ClassTest $classTest,
        MethodTest $methodTest,
        $className, 
        $methodName,
        $format,
        $testName
    ){
        $steps = var_export($methodTest->getSteps(),true);
        $autoloader = $this->createAutoloader($classTest->getMocks());        
        $vars = $this->creatVarDefinitions(array_replace(
            $classTest->getVars(), 
            $methodTest->getVars()
        ));
        $script = $this->core->IO->formatArgs(
            $format,
            $className,
            $classTest->getClass(),
            $methodName,
            $steps, 
            $vars,
            $testName
        );
        return $script;
    }
    
    protected function createAutoloader(array $mocks){
        return $this->core->IO->formatArgs(
            'format/daliaIT/co3/test/MockAutoloader.txt',
            var_export($mocks, true)
        );
    }
    
    protected function creatVarDefinitions(array $vars){
        $definitions = '/*vars*/';
        foreach($vars as $name => $value){
            $definitions .= "\$$name = ".var_export($value, true).';';
        }
        return $definitions;
    }
}