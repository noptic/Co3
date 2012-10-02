<?php
/*/ 
interface **IInject** extends IMake
==========================================================================================
 - authors:   Oliver Anan <oliver@ananit.de>
 - created:   2012/98/06
handle to controll caching at runtime

Usage
------------------------------------------------------------------------------------------
This interface is intended fo cachemanagment and eo handling.
 
If an exception related to cached data occurs you should refresh the data-
 /*/
 
 inteface ICached{
    function flush();
 } 
 ?>