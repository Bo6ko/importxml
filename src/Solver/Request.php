<?php

namespace Solver;

class Request {

    private $get = array();
    private $post = array();
    private $server = array();

    public function __construct(array $get, array $post, array $server) {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }

    public static function getGlobals() {
        return new self($_GET, $_POST, $_SERVER );
    }

    public function getParam($key, $default = null) {
        if ( isset( $this->post[$key] ) ) {
            return $this->post[$key];
        } elseif ( isset( $this->get[$key] ) ) {
            return $this->get[$key];
        }

        return $default;
    }

    public function getPost() {
        return $this->post;
    }

    public function isPost() {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }

    public function getServer() {
        return $this->server;
    }

    public function to($controller) {
        $dir = pathinfo($this->server['SCRIPT_NAME'], PATHINFO_DIRNAME);
        $dir = str_replace('\\', '/', $dir);
        if ($dir === '/') {
            $dir = '';
        }
        header('Location: ' . $dir . '/?controller=' . $controller);
        exit(0);
    }

}