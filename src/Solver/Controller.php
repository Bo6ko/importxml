<?php

namespace Solver;

use Solver\View;

class Controller {

    protected $view;

    public function __construct( View $view ) {
        $this->view = $view;
    }

}