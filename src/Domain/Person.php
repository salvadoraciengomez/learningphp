<?php
    namespace Bookstore\Domain;

    class Person{
        private static $lastId=0;
        protected $id;
        protected $name;
        protected $surname;
        protected $email;

        public function __construct(int $id=null, string $name, string $surname, string $email){
            $this->name = $name;
            $this->surname= $surname;
            $this->email=$email;

            if(empty($id)){
                $this->id = ++self::$lastId;
            }else{
                $this->id = $id;
                if ($id > self::$lastId){
                    self::$lastId=$id;
                }
            }
        }

        public static function getLastId(): int{
            return self::$lastId;
        }

        public function getId():int{
            return $this->id;
        }

        public function getEmail():string{
            return $this->$email;
        }

        public function getName(): string {
            return $this->name;
        }

        public function getSurname(): string{
            return $this->surname;
        }

        
    }
?>