<?php
    //Singleton --> mantiene una única instancia, usado para recursos pesados como conexión a BD o archivos de configuración

    namespace Bookstore\Core;

    use Bookstore\Exceptions\NotFoundException;

    class Config{

        private $data;
        /** OLD SINGLETON REPLACED BY DEPENDENCYINJECTOR (also replacing in Core\Db)
        private static $instance;

        private function __construct(){
            $json = file_get_contents(__DIR__ .'/../../config/app.json');
            $this -> data = json_decode($json, true);
            //self::$data = json_decode($json, true);
        }

        public static function getInstance():Config{
            if (self::$instance == null) {self::$instance = new Self();}
            return self::$instance;
        }
        public function get(string $key){
            //var_dump($this->data);
            if(!isset($this->data[$key])){
                throw new NotFoundException("Key $key not in config.");
            }
            return $this->data[$key];

        }*/

        public function __construct(){
            $json = \file_get_contents(__DIR__.'/../../config/app.json');
            $this->data = json_decode($json, true);
        }

        public function get ($key){
            if (!isset($this->data[$key])) throw new NotFoundException("Key $key not in config.");
            return $this->data[$key];
        }
    }
?>