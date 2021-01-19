<?php

    namespace Bookstore\Domain;

    abstract class Customer extends Person{
        //asbstract obliga a implementar en sus herederos cada método abstract y no puede instanciar objetos
        //abstract se utiliza para asegurarse de que sus hijos estén correctamente implementados
        private static $lastId = 0;

        private $id;
        //private $name; hereda de Person (protected)
        //private $surname; hereda de Person (protected)
        private $email;

        public function __construct( int $id=null, string $name, string $surname, string $email){

            parent::__construct($name, $surname);//Llama al constructor padre
            //Si se sobreescribe (override) un método heredado, se puede hacer referencia parent::metodo()
            //El método overrided debe tener visibilidad igual o más amplia
            if ($id == null){
                $this->id = ++self::$lastId; //self:: es como this, pero para clase (static)
            }else{
                $this->id = $id;
                if ($id > self::$lastId){
                    self::$lastId=$id;
                }
            }

            $this -> name = $name;
            $this -> surname = $surname;
            $this -> email = $email;
        }

        //Tienen que definirse en las clases hijas:
        public abstract function getMonthlyFee();
        public abstract function getAmountToBorrow();
        public abstract function getType();
        
        public static function getLastId():int{
            return self::$lastId;
        }

        public function getId():string{
            return $this->id;
        }

        public function getFirstName(): string{
            return $this->firstname;
        }

        public function getSurname(): string{
            return $this->surname;
        }
        
        public function getEmail(): string{
            return $this->email;
        }

        public function setEmail(string $email){
            $this->email = $email;
        }



    }    
?>