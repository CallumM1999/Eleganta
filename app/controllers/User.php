<?php
    class User {
        public function __construct($page) {
            $this->$page();
        }

        private function index() {
            echo '<p>Index</p>';
        }

        private function profile() {
            echo '<p>Profile</p>';
        }
        
    }