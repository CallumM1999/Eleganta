<?php
    class Route {
         public static function __callStatic($method, $args) {

            // Check if method is in array below
            $methods = ['get', 'post', 'put', 'patch', 'delete', 'options'];
            if (in_array($method, $methods, true) && self::checkMethod($method)) {               
                self::handleRequest($args[0], $args[1]);
            }

            // Check if method matches item in array
            if ($method === 'match') {
                $methods = $args[0];

                if (in_array(strtolower($_SERVER['REQUEST_METHOD']), $methods, true)) {               
                    self::handleRequest($args[1], $args[2]);
                }
            }

            // Accepts any metod
            if ($method === 'any') {
                self::handleRequest($args[0], $args[1]);
            }
        }

        /*

            Add Route methods
            ===============
            Route::redirect('/here', 'there', 301);
            Route::permamentRedirect('/here', 'there');

            Route::View('/profile', 'User@profile', ["title" => "Profile"])

            View parameters in url
            Route::get('/users/{id}')
            Optional parameters
            Route::get('/users/{id?}') function($id = null)
            Regex constraints on url

        */

        private static function checkMethod($method) {
            return (strtoupper($method) === $_SERVER['REQUEST_METHOD']);
        }

        private static function handleRequest($path, $controller) {
            $url = self::getUrl();

            if ($path === $url || $path === '*') {
                self::loadPage($path, $controller);
            }
        }

        private static function loadPage($path, $controller) {
            $params = explode('@', $controller);
            $cname = $params[0];
            $page = (isset($params[1])) ? $params[1] : 'index';

            require_once APPROOT . '/controllers/' . $cname . '.php';

            new $cname($page);

            exit();
        }

        private static function getUrl() {
            return (isset($_GET['url'])) ? '/' . $_GET['url'] : '/';
        }
    }

