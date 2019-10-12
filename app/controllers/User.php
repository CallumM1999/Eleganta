<?php

    class User extends Controller {
        public function index() {

            $data = [
                "title" => 'Page title'
            ];

            View::render('index', $data);
        }

        public function test() {
            View::render('test');
        }

        public function profile($params) {            

            $data = [
                "id" => $id,
                "name" => $params['name']
            ];

            View::render('profile', $data);
        }
    }