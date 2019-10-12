<?php
    class Route {
         public static function __callStatic($method, $args) {
            $methods = ['get', 'post', 'put', 'patch', 'delete', 'options'];

            if (in_array($method, $methods, true)) {
                self::handleRequest($args[0], $args[1]);
            }
        }

        /*

            ===============
            Methods to add:
            ===============

            request::match(['get', 'post'])
            request::any('/')

            ===============
            View parameters in url
            request::get('/users/{id}')

        */

        private static function handleRequest($path, $controller) {
            $url = self::getUrl();

            if ($path === $url) {
                self::loadPage($path, $controller);
            }
        }

        private static function loadPage($path, $controller) {
            $url = self::getUrl();

            if ($path === $url) {
                $params = explode('@', $controller);

                $cname = $params[0];
                $page = (isset($params[1])) ? $params[1] : 'index';

                require_once APPROOT . '/controllers/' . $cname . '.php';

                new $cname($page);

                exit();
            }
        }

        private static function getUrl() {
            return (isset($_GET['url'])) ? '/' . $_GET['url'] : '/';
        }
    }

