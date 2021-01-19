<?php

   require_once __DIR__ . '/Book.php';



    $book = new Book("1984", "George Orwell",976453578483,12);

    
    var_dump($book);

    if ($book->getCopy()){
        echo 'Here, your copy';
    }else {
        echo 'I am afraid that book is not available.';
    }

    $string = (string) $book;
    echo '<br>'.$string;

    //$unidades = (int) $book->__get($available);


    /**VISIBILIDAD
     * private: accesible para objetos de una misma clase. Si A y B son instancias de %, acceden
     * protected: como private pero también para clases que hereden de la misma
     * public: anywhere
     */


?>