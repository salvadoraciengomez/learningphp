<?php
    namespace Bookstore\Core;

    class Request{
        //Clase REQUEST para manejar las peticiones
        const GET = 'GET';
        const POST = 'POST';

        private $domain;
        private $path;
        private $method;

        private $params;
        private $cookies;

        public function __construct(){
            $this->domain = $_SERVER['HTTP_HOST'];
            //$this->path = $_SERVER['REQUEST_URI'];
            $this->path= explode('?', $_SERVER['REQUEST_URI'])[0];
            $this->method= $_SERVER['REQUEST_METHOD'];
            $this->params = new FilteredMap(array_merge($_POST, $_GET)); //Uso de la clase FilteredMap para evitar coger directamente $_POST o $_COOKIE (sec)
            $this->cookies = new FilteredMap($_COOKIE);
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

        public function getParams(): FilteredMap{
            return $this->params;
        }

        public function getCookies(): FilteredMap{
            return $this->cookies;
        }
        //Se podría hacer $price=$request->getParams()->getNumber('price'); 
        //más seguro que $price= $_POST['price];
    }
?>