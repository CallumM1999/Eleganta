<?php
    class Base extends Controller {

        public function notfound() {
            View::render('notfound');
        }
    }