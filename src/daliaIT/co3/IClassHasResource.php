<?php
namespace daliaIT\co3;
interface IClassHasResource{
    #:string
    public function getText($path);
    
    #:string
    public function formatArgs($path);
    
    #:string
    public function formatArray($path, array $args);
}