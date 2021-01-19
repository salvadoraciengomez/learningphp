<?php
    namespace Bookstore\Domain;

    use Bookstore\Utils\Unique;

    class Person{
        use Unique; //Requerido para usar setId() en el constructor. 
        //Si se usara el Unique desde las clases BASIC & PREMIUM, cada una tendría su static diferente

        /** Suponiendo que haya en uso 2 traits diferentes que compartan nombre de algún método (ej:method()): 
         * (si el método es de clase tendría preferencia el de clase sobre los de los trait)
         * class Ejemplo{
         * use Trait1, Trait2{
         *  Trait1::method insteadof Trait2;
         *  Trait2::method as method_renamed;
         *  }
         * }
         * $ej1 = new Ejemplo();
         * $ej1->method(); //Hace el del Trait1
         * $ej1->method_renamed(); //Hace el del Trait2
         * 
        */

        //private static $lastId=0; Al hacer uso del TRAIT Unique, se dejan los id para usarlos desde allí
        //protected $id;
        protected $name;
        protected $surname;
        protected $email;

        public function __construct(int $id=null, string $name, string $surname, string $email){
            $this->name = $name;
            $this->surname= $surname;
            $this->email=$email;
            $this->setId($id); //Hace uso del trait Unique

            if(empty($id)){
                $this->id = ++self::$lastId;
            }else{
                $this->id = $id;
                if ($id > self::$lastId){
                    self::$lastId=$id;
                }
            }
        }

        /**Antiguos métodos antes del uso del TRAIT */
        // public static function getLastId(): int{
        //     return self::$lastId;
        // }

        // public function getId():int{
        //     return $this->id;
        // }

        public function getEmail():string{
            return $this->$email;
        }

        public function getName(): string {
            return $this->name;
        }

        public function getSurname(): string{
            return $this->surname;
        }

        public function setEmail(string $email){
            $this->email = $email;
        }

        
    }
?>