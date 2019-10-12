<?php

    abstract class Controller {
        public function __construct($page) {
            $this->$page();
        }
    }