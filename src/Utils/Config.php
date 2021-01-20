<?php
    //Singleton --> mantiene una única instancia, usado para recursos pesados como conexión a BD o archivos de configuración

    namespace Bookstore\Utils;

    use Bookstore\Exceptions\NotFoundException;

    class Config{
        private $data;

        public function __construct(){
            $json = file_get_contents(__DIR__ . '/../../config/app.json');
            $this -> data = json_decode($json, true);
        }

        public function get(string $key){
            if(!isset($this->data[$key])){
                throw new NotFoundException("Key $key not in config.");
            }
            return $this->data[$key];
        }
    }
?>