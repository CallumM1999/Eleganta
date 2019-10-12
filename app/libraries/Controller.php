<?php

    abstract class Controller {
        public function __construct($page, $params) {
            $this->$page($params);
        }
    }