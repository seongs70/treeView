<?php

    $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'ghfjdk');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

