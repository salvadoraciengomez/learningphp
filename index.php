<?php
    use Bookstore\Core\Router;
    use Bookstore\Core\Request;
    
    require_once __DIR__ . '/vendor/autoload.php';


/**    CODE FOR TESTING VIEWS
    use Bookstore\Models\BookModel;
    use Bookstore\Models\SaleModel;
    use Bookstore\Utils\Config;
    use Bookstore\Core\Db;

    
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
    $twig = new Twig_Environment($loader);

    //PostPRECATED
    // $loader= new Twig\Loader\FilesystemLoader(__DIR__.'/views');
    // $twig = new \Twig\Environment($loader);
    


    $bookModel = new BookModel(Db::getInstance());
    //var_dump($bookModel->get(1));
    //$book = $bookModel->get(1);
    $books = $bookModel->getAll(1,3);

    $params = ['books'=> $books, 'currentPage' => 2];
    echo $twig->loadTemplate('books.twig')->render($params);

    //Prepare to sale.twig
    $saleModel = new SaleModel(Db::getInstance());
    $sales = $saleModel->getByUser(1);

    $params = ['sales' => $sales];
    echo $twig->loadTemplate('sales.twig')->render($params);

    $saleModel = new SaleModel(Db::getInstance());
    $sale = $saleModel->get(5);

    $params= ['sale' => $sale];
    echo $twig->loadTemplate('sale.twig')->render($params);
    */


    //Adding Dependency Injector
    $config = new Config();

    $dbConfig = $config->get('db');

    $db = new PDO(
        'mysql:host=127.0.0.1;dbname=bookstore',
        $dbConfig['user'],
        $dbConfig['password']
    );

    $loader = new Twig_Loader_Filesystem(__DIR__.'/../../views');
    $view = new Twig_Environment($loader);

    $log = new Logger('bookstore');
    $logFile = $config->get('log');
    $log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

    $di = new DependencyInjector();
    $di->set('PDO', $db);
    $di->set('Utils\Config', $config);
    $di->set('Twig_Environment', $view);
    $di->set('Logger', $log);


    $router = new Router();
    $response = $router->route(new Request());
    echo $response;

?>