<?php
    class Route {
        public static function get($path, $cb) {
            $url = self::getUrl();

            $request = [
                "path" => $path,
                "method" => "get"
            ];
            $response = [];

            if ($path === $url) {
                $cb($request, $response);
                exit();
            }
        }

        private static function encodeParams($params) {
            return '/' . join('/', $params);
        }

        private static function getUrl() {
            if (isset($_GET['url'])) {
                return '/' . $_GET['url'];                
            } 
            return '/';
        }
    }