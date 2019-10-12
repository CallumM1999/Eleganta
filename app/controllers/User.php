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

        public function profile() {            

            $data = [
                "id" => '1234'    
            ];

            View::render('profile', $data);
        }
    }