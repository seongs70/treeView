<?php

namespace Route;

Class Routes
{
    private $ptnrTable;

    public function __construct(){
        include __DIR__ . '/../Connect/conn.php';
        $this->ptnrTable = new \Model\DatabaseTable($pdo, 'orgasample', 'ptnr_mp');

    }

    public function getRoutes(): array{
        $ptnrController = new \Controller\Ptnr($this->ptnrTable);

        $routes = [
            'ptnr/treegrid' =>[
                'GET' =>[
                    'controller' => $ptnrController,
                    'action' => 'treegrid'
                ],
                'POST' =>[
                    'controller' => $ptnrController,
                    'action' => 'treegrid'
                ]
            ],
            'ptnr/view' => [
                'POST' =>[
                    'controller' => $ptnrController,
                    'action' => 'view'
                ]
            ]
        ];
        return $routes;
    }
}