<?php
    class Base extends Controller {

        public function home() {
            $data = [
                "title" => "Home Page"
            ];

            View::render('home', $data);
        }

        public function notfound() {
            http_response_code(404);
            View::render('notfound', ["title" => "404"]);
        }

        public function post() {
            View::render('post');
        }

        public function match() {
            $data = [
                "title" => "Match"
            ];

            View::render('match', $data);
        }

        public function any() {
            $data = [
                "title" => "Any Page"
            ];

            View::render('any', $data);
        }

        public function middleware($request, $params) {

            $data = [
                'auth' => (isset($request['auth']) && $request['auth'] === true) ? 'true' : 'false',
                "title" => "Middleware Page"
            ];

            View::render('middleware', $data);
        }

        public function func() {
            View::render('func');
        }
    }