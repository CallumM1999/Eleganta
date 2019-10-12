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

        */

        private static function checkMethod($method) {
            return (strtoupper($method) === $_SERVER['REQUEST_METHOD']);
        }

        private static function handleRequest($path, $action) {
            $decodedPath = self::decodePath($path);

            // Valid path, parameters array returned
            if (is_array($decodedPath)) {
                // Check if route uses a controller, or runs inline function
                            
                if (is_callable($action)) {
                    // Extract index array [12, 'callum'];
                    $args = array_map(function($param) {
                        return current($param);
                    }, $decodedPath);

                    // Call passed function with params
                    call_user_func_array($action, $args);
                } else {
                    // Extract Associative array [id => 12, name => 'callum']
                       $params = array_reduce($decodedPath, function ($result, $item) {
                        $key = key($item);
                        $value = current($item);

                        $result[$key] = $value;
                        return $result;
                    }, array());

                    // Load controller with params
                    self::loadPage($action, $params);
                }
            }
        }

        private static function decodePath($path) {
            $url = self::getUrl();

            // Split URL and path into array
            $urlArr = explode('/', $url);
            $urlArr[0] = 'index';

            $pathArr = explode('/', $path);
            $pathArr[0] = 'index';

            // Return empty array (No parameters)
            if ($path === '*') return [];
            
            // URL and params don't match, since array size should be same
            if(sizeof($urlArr) !== sizeof($pathArr)) return false;
            
            // Parameters extracted from URL
            $parameters = [];

            $length = sizeof($urlArr);

            for ($i=0; $i<$length;$i++) {

                $urlBlock = $urlArr[$i];
                $pathBlock = $pathArr[$i];

                // Check if param block is param /users/{id}
                $extractParameter = self::extractUrlParams($pathBlock);

                if ($extractParameter !== false) {
                    // Parameter found
                    $parameter = $extractParameter;

                    // Add parameter to parameters array
                    // formatted as array inside array because we need to use a key, and keep the order
                    $parameters[] = [$parameter => $urlBlock];
                } else if ($urlBlock !== $pathBlock) {
                    // URL doesnt match path, no point checking any other blocks
                    return false;
                }
            }
                
            // If we've got this far, the URL must match
            return $parameters;
        }

        private static function extractUrlParams($block) {
            $regex = '/{\K[^}]*(?=})/m';
            preg_match_all($regex, $block, $results);

            // If results are not empty, a parameter was found
            return (sizeof($results[0]) > 0) ? $results[0][0] : false;
        }

        private static function loadPage($controller, $parameters = []) {
            $params = explode('@', $controller);
            $cname = $params[0];
            $page = (isset($params[1])) ? $params[1] : 'index';

            require_once APPROOT . '/controllers/' . $cname . '.php';

            new $cname($page, $parameters);

            exit();
        }

        private static function getUrl() {
            return (isset($_GET['url'])) ? '/' . $_GET['url'] : '/';
        }
    }

