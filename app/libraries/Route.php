<?php
    class Route {
        public static function get($path, $controller) {
            self::handleRequest($path, $controller);       
        }

        public static function post($path, $controller) {
            self::handleRequest($path, $controller);       
        }

        public static function put($path, $controller) {
            self::handleRequest($path, $controller);       
        }

        public static function patch($path, $controller) {
            self::handleRequest($path, $controller);       
        }

        public static function delete($path, $controller) {
            self::handleRequest($path, $controller);       
        }

        public static function options($path, $controller) {
            self::handleRequest($path, $controller);       
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
            $requestMethod = strtoupper(debug_backtrace()[1]['function']);

            if ($_SERVER['REQUEST_METHOD'] === $requestMethod) {
                $url = self::getUrl();

                if ($path === $url) {
                    self::loadPage($path, $controller);
                }
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

