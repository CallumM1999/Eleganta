<?php
    class Base extends Controller {

        public function home() {
            View::render('home');
        }

        public function notfound() {
            http_response_code(404);
            View::render('notfound');
        }

        public function post() {
            View::render('post');
        }

        public function match() {
            View::render('match');
        }

        public function any() {
            View::render('any');
        }

        public function middleware($request, $params) {

            $data = [
                'auth' => (isset($request['auth']) && $request['auth'] === true) ? 'true' : 'false',
            ];

            View::render('middleware', $data);
        }

        public function func() {
            View::render('func');
        }
    }