<?php
    var_dump(__DIR__);
    require_once __DIR__ . '/vendor/autoload.php';

    use Bookstore\Models\BookModel;
    use Bookstore\Utils\Config;
    use Bookstore\Core\Db;


    //$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
    //$twig = new Twig_Environment($loader);


    $loader= new \Twig\Loader\FilesystemLoader(__DIR__.'/views');
    $twig = new \Twig\Environment($loader);
    

    $bookModel = new BookModel(Db::getInstance());
    $book = $bookModel->get(1);

    $params = ['book'=> $book];
    echo $twig->loadTemplate('book.twig')->render($params);