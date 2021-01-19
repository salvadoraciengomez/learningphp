<?php

    namespace Bookstore\Domain;    

    class Book {
        public $isbn;
        public $title;
        public $author;
        public $available;

        public function __construct( 
            string $title, 
            string $author, 
            int $isbn,
            int $available=0)
            {
            $this->isbn= $isbn;
            $this->title= $title;
            $this->author= $author;
            $this->available = $available;
        }
    /**
     * __toString() sin params
     * __call() trata de llamar a un método de una clase que no existe
     * __get() versión de __call para propiedades
     */

    public function __toString(): string{
        $result = '<i>'. $this -> title 
            .'<i> - '. $this->author; 
        if (!$this->available){
            $result.= '<b>Not Available</b>'; //result + str
        }
        return $result;
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

    public function isAbailable(): bool {
        return $this->available;
    }


    public function getCopy(): bool {
        if ($this->available <1){
            return false;
        }else{
            $this->available--;
            return true;
        }
    }

    public function addCopy(){
        $this->available++;
    }
}

?>