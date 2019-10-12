<?php

    class User extends Controller {
        public function index() {

            $data = [
                "title" => 'Page title'
            ];

            View::render('index', $data);
        }

        public function profile() {
            View::render('profile');
        }

        public function post_profile() {
            $data = [
                "message" => "request sent"
            ];

            View::render('profile', $data);
        }
    }