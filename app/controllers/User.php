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
            // Validate ID 
            if (!isset($params['id'])) {
                $id = false;
            } else {
                $id = $params['id'];
            }

            $data = [
                "id" => $id
            ];

            View::render('profile', $data);
        }
    }