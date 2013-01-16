<?php
namespace daliaIT\co3\h2o;
use Exception,
    H2o_File_Loader,
    daliaIT\co3\Core,
    daliaIT\co3\ICoreUser,
    daliaIT\co3\IInject;
    
class ResourceTemplateLoader extends H2o_File_Loader 
implements ICoreUser, IInject
{    
    function __construct($options = array()) {            
    	$this->searchpath = array();
		$this->setOptions($options);
    }
    
    #:string   
    function get_template_path($search_path, $filename){
        $filename = $this->core->IO->file->search($filename);
        if($filename !== null){
            return $filename;
        } else {
            throw new Exception('TemplateNotFound - Looked for template: ' . $filename);
        }
    }
    
    #@import daliaIT\co3\Inject@# 
}