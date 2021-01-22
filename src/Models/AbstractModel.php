<?php
    namespace Bookstore\Models;

    use PDO;

    abstract class AbstractModel{
        private $db;

        public function __construct(PDO $db){
            $this->db = $db;
        }

        public function getDb(){
            return $this->db;
        }
    }
?>