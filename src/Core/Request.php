<?php
    namespace Bookstore\Core;

    class Request{
        //Clase REQUEST para manejar las peticiones
        const GET = 'GET';
        const POST = 'POST';

        private $domain;
        private $path;
        private $method;

        public function __construct(){
            $this->domain = $_SERVER['HTTP_HOST'];
            $this->path = $_SERVER['REQUEST_URI'];
            $this->method= $_SERVER['REQUEST_METHOD'];
        }

        public function getUrl(): string{
            return $this->domain . $this->path;
        }

        public function getDomain(): string{
            return $this->domain;
        }

        public function getPath(): string{
            return $this->path;
        }

        public function getMethod(): string{
            return $this->method;
        }

        public function isPost(): bool {
            return $this->method === self::POST;
        }

        public function isGet(): bool{
            return $this->method === self::GET;
        }
    }
?>