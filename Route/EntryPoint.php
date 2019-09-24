<?php

namespace Route;
// URL경로를 다룬다.
// 리다이렉트 문제가 생기면 checkURL, 템플릿은 loadTemplate(), URL에 접속할 수 없으면 callAction()
//프레임워크 코드와 프로젝트 코드를 분리해 모든 프로젝트에서 사용하는 하나의 EntryPoint 클래스
//EntryPoint 클래스는 생성자로 액션 클래스를 전달한다.
class EntryPoint
{
    private $route;
    private $method;
    private $routes;
    //$route = ptnr/home
    //$method = $_SERVER['REQUEST_METHOD']
    //$routes = Routes클래스 인스턴스
    public function __construct(string $route, string $method, $routes)
    {
        $this->route = $route;
        //$routes는 Routes인스턴스를 담을 변수
        $this->routes = $routes;
        $this->method = $method;
        $this->checkUrl();


    }

    private function checkUrl()
    {
        if($this->route !== strtolower($this->route)){
            http_response_code(301);

            header('location: index.php?route='.strtolower($this->route));
        }
    }

    private function loadTemplate($templateFileName, $variables =[])
    {
        extract($variables);
        ob_start();
        include __DIR__ . '/../view/'.$templateFileName;
        return ob_get_clean();
    }

    //템플릿 기능을 담당
    public function run()
    {
        $routes = $this->routes->getRoutes();
//        echo '<pre>';
//        print_r($routes);
//        echo '</pre>';


        $controller = $routes[$this->route][$this->method]['controller'];

        $action = $routes[$this->route][$this->method]['action'];
        
        $page = $controller->$action();

    }
}