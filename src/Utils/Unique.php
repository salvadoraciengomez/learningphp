<?php
    namespace Bookstore\Utils;
    
    //NOT WORKING
    use Bookstore\Exceptions\ExceededMaxAllowedException;
    use Bookstore\Exceptions\InvalidException;



    

    trait Unique{

        private static $lastId=0;
        protected $id;

        public function setId(int $id=null){

            // if ($id < 0){
            //     //throw new \Exception('Id cannot be negative'); //Necesita 'use Exception;' si no se utiliza el backslash
            //     throw new InvalidException('Id cannot be negative');
            // }
            // if (empty($id)){
            //     $this->id= ++self::$lastId;
            // }else{
            //     $this->id = $id;
            //     if ($id > self::$lastId){
            //         self::$lastId = $id;
            //     }
            // }
            
            // if ($this->id >50){
            //     throw new ExceededMaxAllowedException('Max number of users is 50');
            // }

            $this->id = $id;
        }

        // public static function getLastId(): int{
        //     return self::$lastId;
        // }

        public function getId():int{
            return $this->id;
        }
    }
?>