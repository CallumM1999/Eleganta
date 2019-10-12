<?php
    class Base extends Controller {

        public function notFound() {
            View::render('notfound');
        }
    }