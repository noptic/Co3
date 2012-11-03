<?php
/*/
class daliaIT\co3\IO\converter\SerializationTest extends daliaIT\co3\App
================================================================================

 Ke         | Vakue
 -----------|---------------------------------
 Author     | Oliver Anan \oliver@ananit.de
 Version    | 0.1
 Package    | co3

Tests serialization and deserialization.
This test will use the registerd filters for testing.

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\co3\IO\test;
use Exception,
    daliaIT\co3\util\generator\ArrayGenerator,
    daliaIT\co3\app\App;
    
class SerializationTest extends App
{
    public
        #:mxed[]
        $reimportTestData = array(
            'int'    => 124816,    
            'bool'   => true,
            'float'  => 1.23,
            'string' => "Lorem ipsum\n semper sit"
        ),
        $pluginData;

        
    public function run(){
        parent::run();
        if($this->core == null) throw new Exception(
            'No core found'  
        );
        $this->testFiltersOnScalarValues();
    }
    
    public function testFiltersOnScalarValues(){
        $inAndOutFilters = array();      
        foreach($this->core->IO->getFilters() as $filter){
            if($filter->getIsInFilter() && $filter->getIsOutFilter() ){
                $inAndOutFilters[] = $filter;
            }
        }
        
        ArrayGenerator::mk( array(
            array($this), 
            $this->reimportTestData, 
            $inAndOutFilters)
        )
        ->walk( function($context, $value,$filter){
            $exported =  $context->getCore()->IO->out($value, $filter);
            $reimport =  $context->getCore()->IO->in($exported, $filter);
            if( ($reimport != $value)
                && (!(
                    is_array($reimport) 
                    && (count($reimport) == 1) 
                    && $reimport[0] == $value
                ))
            ){
                $before = print_r($value, true);
                $during = print_r($exported, true);
                $after = print_r($reimport, true);
                $filter = print_r( $filter, true );
                throw new Exception(implode("\n", array(
                    "Scalar value changed by exporting and importing.",
                    "Before: $before",
                    "During: $during",
                    "After: $after",
                    "Filter: '{$filter}'",
                    "Note on strings:",
                    "Linebreak style and trailing whitespace is *not* preserved"
                    ))
                );    
            } 
        
        }); 
    }
    

}