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
        $filterTestData = array(
            'int'    => array(
                'out' => array(
                    array('in'=>    1,      'result' => '1'     ),          
                    array('in'=>    1234,   'result' => '1234'  ),  
                    array('in'=>    0,      'result' => '0'     ),   
                    array('in'=>    -1,     'result' => '-1'    ),  
                    array('in'=>    1.5,    'result' => '1'     ),   
                    array('in'=>    '1.5',  'result' => '1'     ),  
                    array('in'=>    '0',    'result' => '0'     ),  
                    array('in'=>    '2 bad','result' => '2'     ),
                    array('in'=>    null,   'result' => '0'     ),
                ),
                'in' => array(
                    array('in'=>    null,   'result' => 0       ),
                    array('in'=>    '10',   'result' => 10      ),
                    array('in'=>    '-42',  'result' => -42     ),
                    array('in'=>    '1.8',  'result' => 1       ),
                )
            ),
            'float' => array(
                'out' => array(
                    array('in'=>    10.0,   'result' => '10'    ),
                    array('in'=>    23.2,   'result' => '23.2'  ),
                    array('in'=>    -0.1,   'result' => '-0.1'  ),
                    array('in'=>    0.0,    'result' =>  '0'    ),
                ),
                'in' => array(
                    array('in'=>     '0.3', 'result' => 0.3     ),
                    array('in'=>     '0',   'result' => 0.0     ),
                    array('in'=>     '-1.2', 'result' => -1.2   ),
                    
                )
            ),
            'bool' => array(
                'out' => array(
                    array('in'=>    1,      'result' => 'true'  ),
                    array('in'=>    true,   'result' => 'true'  ),
                    array('in'=>    24,     'result' => 'true'  ),
                    array('in'=>    array(1),'result'=>  'true' ),
                    array('in'=>    -1,     'result' =>  'true' ),
                    array('in'=>    'true','result'  =>  'true' ),
                    array('in'=>    0,      'result' =>  'false'),
                    array('in'=>    false,  'result' =>  'false'),
                    array('in'=>    'false','result' =>  'false'),
                    array('in'=>    array(),'result' =>  'false'),
                    array('in'=>    null,   'result' =>  'false'),
                ),
                'in' => array(
                    array('in'=>     '0.3', 'result' => true    ),
                )
            ),
        ),
        $pluginData;

        
    public function run(){
        parent::run();
        if($this->core == null) throw new Exception(
            'No core found'  
        );
        $this->testFilters();
    }
    
    public function testFilters(){
        foreach($this->filterTestData as $filter => $testDataList){
            #TODO test if filter exists
            if(isset ($testDataList['out'])){
                foreach($testDataList['out'] as $testData){    
                    $result = $this->core->IO->out($testData['in'], $filter);
                    if($result !== $testData['result']){
                        throw new Exception(
                            implode("\n",array(
                                "Exported data does not match the excpected result",
                                "Filter; ".$filter,
                                "Exported: "
                                    .gettype($testData['in']).' '
                                    .var_export($testData['in'],true),
                                "Expected: "
                                    .gettype($testData['result']).' '
                                    .var_export($testData['result'],true),
                                "Got: "
                                    .gettype($result).' '
                                    .var_export($result,true),
                            ))
                        );
                    }
                }
            }
            if(isset ($testDataList['in'])){
                foreach($testDataList['in'] as $testData){    
                    $result = $this->core->IO->in($testData['in'], $filter);
                    if($result !== $testData['result']){
                        throw new Exception(
                            implode("\n",array(
                                "Imported data does not match the excpected result",
                                "Filter; ".$filter,
                                "Imported: "
                                    .gettype($testData['in']).' '
                                    .var_export($testData['in'],true),
                                "Expected: "
                                    .gettype($testData['result']).' '
                                    .var_export($testData['result'],true),
                                "Got: "
                                    .gettype($result).' '
                                    .var_export($result,true),
                            ))
                        );
                    }
                }
            }
        }
    }
    
}