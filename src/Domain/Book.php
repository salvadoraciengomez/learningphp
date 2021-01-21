<?php

    namespace Bookstore\Domain;    

    class Book {
        //Se usará la clase libro para modelar objetos desde la base de datos
        //atributos como las columnas, privados (sin setters)
        //sin constructor a menos que se requiera para otros propósitos
        private $id;
        private $isbn;
        private $title;
        private $author;
        private $stock;
        private $price;

        // public function __construct( 
        //     string $title, 
        //     string $author, 
        //     int $isbn,
        //     int $available=0)
        //     {
        //     $this->isbn= $isbn;
        //     $this->title= $title;
        //     $this->author= $author;
        //     $this->available = $available;
        // }

    /**
     * __toString() sin params
     * __call() trata de llamar a un método de una clase que no existe
     * __get() versión de __call para propiedades
     */

    public function __toString(): string{
        $result = '<i>'. $this -> title 
            .'<i> - '. $this->author; 
        // if (!$this->available){
        //     $result.= '<b>Not Available</b>'; //result + str
        // }
        return $result;
    }

    public function getId():int{
        return $this->id;
    }

    public function getIsbn(): int{
        return $this->isbn;
    }

    public function getTitle(): string{
        return $this->title;
    }

    public function getAuthor(): string{
        return $this->author;
    }

    // public function isAbailable(): bool {
    //     return $this->available;
    // }

    public function getStock(): int{
        return $this->stock;
    }

    public function getCopy(): bool {
        if ($this->stock <1){
            return false;
        }else{
            $this->stock--;
            return true;
        }
    }

    public function addCopy(){
        $this->stock++;
    }

    public function getPrice():float{
        return $this->price;
    }
}

?>