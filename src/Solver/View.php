<?php

namespace Solver;

class View {

    protected $data = array();

    protected $path = array();

    public function render( $path ) {
        include $path;
        return;
    }

    public function addPath( $path ) {
        return $this->path = $path;
    }

    public function assign($key, $value) {
        $this->data[$key] = $value;
        return $this;
    } 

    public function getPath() {
        return $this->path;
    }

    public function getData() {
        return $this->data;
    }

}