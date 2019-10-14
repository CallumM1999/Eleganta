<?php

    abstract class Controller {
        public function __construct($page, $request, $params) {
            $this->$page($request, $params);
        }
    }