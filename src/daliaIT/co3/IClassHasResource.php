<?php
namespace daliaIT\co3;
interface IClassHasResource{
    public function getText($path);
    
    public function formatArgs($path);
    
    public function formatArray($path, array $args);
}