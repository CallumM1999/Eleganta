<?php
    class Route {
        public static function get($path, $controller) {
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

