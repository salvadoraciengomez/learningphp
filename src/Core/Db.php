<?php
    namespace Bookstore\Core;

    use PDO;

    class Db{
    //Singleton Class for accessinf DB (Model)
    //Cuando se necesite una conexión se escribirá  Db::getInstance()
        private static $instance;

        private static function connect(): PDO{
            $dbConfig = Config::getInstance()->get('db');

            return new PDO(
                'mysql:host=127.0.0.1;dbname=bookstore',
                $dbConfig['user'],
                $dbConfig['password']
            );
        }

        public static function getInstance(){
            if (self::$instance == null) {
                //echo "NULLDB";
                self::$instance = self::connect();
            }
            return self::$instance;
        }
    }
?>