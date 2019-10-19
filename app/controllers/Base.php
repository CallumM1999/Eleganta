<?php
    namespace Controller;


    use \View as View;

    class Base extends \Controller {

        public function __construct() {
            $this->baseModel = $this->model('Base');
        }

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
            $results = $this->baseModel->getUsers();

            $data = [
                "users" => $results,
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