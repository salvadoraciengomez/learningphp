<?php
    namespace Bookstore\Exceptions;

    use Exception;

    class InvalidException extends Exception{
        public function __construct($message = null){
            $message = $message ?: 'Invalid id provided.'; 
            //:? es un if que hace la parte izquierda si true o la derecha si false (valor nulo de $message)
            parent::__construct($message);
        }
    }
?>