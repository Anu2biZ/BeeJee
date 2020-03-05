<?php

    class Router
    {
        private $routes;

        /*
        * returns request string
        * @return string
        */

        private function getURI()
        {
            if ( ! empty($_SERVER['REQUEST_URI']) )
            {
               return trim($_SERVER['REQUEST_URI'], '/');
            }
        }

        public function __construct()
        {
            $routesPath = ROOT . '/config/routes.php';
            $this->routes = include($routesPath);
        }

        public function run()
        {
            // get URI
            $uri = $this->getURI();
            foreach ($this->routes as $uriPattern => $path)
            {
                if (preg_match("~$uriPattern~", $uri))
                {
                    $segments = explode('/', $path);

                    // get controller and action
                    $controllerName = ucfirst(array_shift($segments) . 'Controller');
                    $actionName = 'action' . ucfirst(array_shift($segments));

                    // get controller file
                    $controllerFile = $controllerName . '.php';
                    if (file_exists(ROOT . '/controllers/' . $controllerFile))
                    {
                        require_once(ROOT . '/controllers/' . $controllerFile);
                    }
                    else {
                    exit;
                    }


                    // create Object, call action
                    $controllerObject = new $controllerName;
                    $result = $controllerObject->$actionName();

                    if ($result) break;

                }
            }
        }
    }


?>