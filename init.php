<?php

    //Si se utiliza un namespace, solo se acceden a dichas clases. Para agregar varios: use
    use Bookstore\Domain\Book;
    use Bookstore\Domain\Customer;
    //Para usar otra clase con el nombre Book se debería especificar el namespace completo en el new

    require_once __DIR__ . '/Book.php';
    require_once __DIR__ . '/Customer.php';
    
    //$book1 = new Bookstore\Domain\Book("1984", "George Orwell", 9785267006323, 12); using new with namespace keyword without use keyword
    $book1 = new Bookstore\Domain\Book("1984", "George Orwell", 9785267006323, 12);
    $book2 = new Book("To Kill a Mockingbird", "Harper Lee", 9780061120084, 2);

    $customer1 = new Customer(1, 'John', 'Doe', 'johndoe@mail.com');
    $customer2 = new Customer(2, 'Mary', 'Poppins', 'mp@mail.com');

    $book1->available = 2;
    //echo $customer1->id;  Can't access private
    echo((string) $customer2->getId()); //using public getter to access private attrib (encapsulamiento)

    $customer1 = new Customer(3, 'John', 'Doe', 'johndoe@mail.com');
    $customer2 = new Customer(null, 'Mary', 'Poppins', 'mp@mail.com');
    $customer3 = new Customer(7, 'James', 'Bond', '007@mail.com');

    $customer3::getLastId(); //using class static attrib getter

?>