<?php

try{

    include __DIR__ . '/../Connect/autoload.php';

    $route = $_GET['route'] ?? 'ptnr/treegrid';

    $entryPoint = new \Route\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Route\Routes());
    $entryPoint->run();


//    $ptnrController = new \Controller\Ptnr($ptnrTable);


} catch (PDOException $e){
    $ouput = '데이터베이스 오류:' .  $e->getMessage() . ', 위치:'. $e->getFile() . ':' . $e->getLine();

}