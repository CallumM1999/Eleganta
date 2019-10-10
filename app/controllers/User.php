<?php

    class User extends Controller {
        public function __construct($page) {
            $this->$page();
        }

        private function index() {
            // echo '<p>Index</p>';

            View::render('User@index');
        }

        private function profile() {
            View::render('User@profile');
        }
    }