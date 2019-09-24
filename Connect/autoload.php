<?php
function autoloader($className)
{
    $fileName = str_replace('\\','/',$className);
    $dirs = array(
        '/Connect/',
        '/Controller/',
        '/Model/'
    );
//    foreach($dirs as $dir){

//        echo __DIR__ . '/../' . $fileName . '.php'.'<br>';
        if(file_exists(__DIR__ . '/../' . $fileName . '.php')){

            include(__DIR__ . '/../' . $fileName . '.php');
        }

//    }
}

spl_autoload_register('autoloader');