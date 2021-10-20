<?php

function conectarDB() : mysqli{
    $db = new  mysqli('localhost','root','','bienesraices_crud');
    $db->set_charset('utf8');
    if(!$db){
        echo "No hay conección";
        exit;
    }
    
   return $db;
}