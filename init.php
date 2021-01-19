<?php

    //Si se utiliza un namespace, solo se acceden a dichas clases. Para agregar varios: use
    use Bookstore\Domain\Book;
    use Bookstore\Domain\Customer;
    use Bookstore\Domain\Customer\Basic;
    use Bookstore\Domain\Customer\Premium;
    //Para usar otra clase con el nombre Book se debería especificar un alias en el use:
    //use Library\Domain\Book as LibraryBook; new LibraryBook();


    //Importaría todas las clases que haya en ./src 
    //Siguiente función era originalmente __autoload, cambia a autoloader para hacer uso de spl_autoload_register
    function autoloader($classname){ //__autoload Deprecated in PHP8 por spl_autoload_register()
        $lastSlash = strpos($classname,'\\')+1;
        $classname= substr($classname,$lastSlash);
        $directory = str_replace('\\', '/', $classname);
        $filename = __DIR__ . '/src/' . $directory . '.php';
        require_once($filename);
    }
    spl_autoload_register('autoloader');

    /**Deprecated (autoloader does):
    * require_once __DIR__ . '/Book.php';
    * require_once __DIR__ . '/Customer.php'; */
    
    //$book1 = new Bookstore\Domain\Book("1984", "George Orwell", 9785267006323, 12); using new with namespace keyword without use keyword
    $book1 = new Bookstore\Domain\Book("1984", "George Orwell", 9785267006323, 12);
    $book2 = new Book("To Kill a Mockingbird", "Harper Lee", 9780061120084, 2);

    $customer1 = new Premium(1, 'John', 'Doe', 'johndoe@mail.com');
    $customer2 = new Premium(2, 'Mary', 'Poppins', 'mp@mail.com');

    $book1->available = 2;
    //echo $customer1->id;  Can't access private
    echo((string) $customer2->getId()); //using public getter to access private attrib (encapsulamiento)

    $customer1 = new Basic(3, 'John', 'Doe', 'johndoe@mail.com');
    $customer2 = new Basic(null, 'Mary', 'Poppins', 'mp@mail.com');
    $customer3 = new Premium(7, 'James', 'Bond', '007@mail.com');

    $customer3::getLastId(); //using class static attrib getter



    //Comprobando métodos overriden (funcionaría con cualquier clase que herede de Customer)
    function checkIfValid(Customer $customer, array $books):bool{
        return $customer->getAmountToBorrow() >= count($books);
    }

    //Habría que añadir use Bookstore\Domain\Customer\Basic;
    $customer1 = new Basic (5, 'John', 'Doe', 'jophndoe@mail.vom');
    var_dump(checkIfValid($customer1,[$book1])); //true

    $customer2 = new Basic(7, 'James', 'Bond', 'jamesbopnd@gmail.com');
    //var_dump(checkIfValid($customer2, [$book1]));  No encontraría checkIfValid porque getAmountToBorrow() no está en Customer


    //Uso de traits
    $basic1 = new Basic (1,"name","surname","email");
    $basic2 = new Basic (null,"name","surname","email");

    var_dump($basic1->getId());
    var_dump($basic2->getId());


    //Uso de try local, Excepcion definida en el trait Unique (setId()). 
    //Si se usa try se debe seguir del uso de catch o finally, pudiendo usar ambos
    //catch maneja la excepcion, ejecuta al haber error
    //Finally se ejecuta cuando el try se hace bien o tras hacer el catch
    /*try{
        $basic = new Basic (-1, "name", "surname","email");
    } catch (Exception $e) {
        echo 'Something wrong using constructor:'. $e->getMessage();
        }
    */

    function createBasicCustomer($id){
        try{
            echo "\nTrying to create a new customer. \n";
            return new Basic($id,"name","surname","email");
        }catch (Exception $e){
            echo "Something happened when creating the basic customer: "
            .$e->getMessage()."\n";
        }finally{
            echo "End of function.\n";
        }
    }

    createBasicCustomer(1);
    createBasicCustomer(-1);
    
?>