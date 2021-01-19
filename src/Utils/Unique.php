<?php
    namespace Bookstore\Utils;
    //NOT WORKINGnamespace Bookstore\Exceptions;

    

    trait Unique{

        private static $lastId=0;
        protected $id;

        public function setId(int $id=null){

            if ($id < 0){
                throw new \Exception('Id cannot be negative'); //Necesita 'use Exception;' si no se utiliza el backslash
                //NOTWORKINGthrow new InvalidException('Id cannot be negative');
            }
            if (empty($id)){
                $this->id= ++self::$lastId;
            }else{
                $this->id = $id;
                if ($id > self::$lastId){
                    self::$lastId = $id;
                }
            }
            
        }

        public static function getLastId(): int{
            return self::$lastId;
        }

        public function getId():int{
            return $this->id;
        }
    }
?>