<?php
    namespace Bookstore\Core;

    use Bookstore\Controllers\ErrorController;
    use Bookstore\Controllers\CustomerController;
    use Bookstore\Controllers\Customer;
    use Bookstore\Utils\DependencyInjector;

    class Router{
        private $routeMap;
        private static $regexPatters=[
            'number' => '\d+',
            'string' => '\w'
        ];

        public function __construct(DependencyInjector $di){
            //Al crear Router se lee el routes.json para comprobar si corresponde a algún controlador el objeto Request enviado al método route()
            $this->di= $di;
            $json = file_get_contents( __DIR__ . '/../../config/routes.json');
            $this->routeMap= json_decode($json, true);
        }

        public function route(Request $request,DependencyInjector $di): string{
            //coge un objeto Request y devuelve una cadena que recibirá el cliente. Comprueba todas las rutas hasta encontrar la propia y enviarla al controlador
            $path = $request->getPath();
            $path=explode('/', $path)[4];
            //var_dump($path);
            $i=0;
            foreach ($this->routeMap as $route => $info){
                $regexRoute = $this->getRegexRoute($route, $info);
                //var_dump($regexRoute);
                var_dump($i);
                var_dump($regexRoute);
                var_dump($path);
                echo "<br>";
                $i++;
                if (preg_match("@$regexRoute@",$path)){
                    //comprueba la expresión (1er arg) sobre $path. Devuelve false si no encuentra
                    

                    //EXPRESIONES:
                    // ^ Especifica que la parte a encontrar debe estar al principio de la cadena
                    // $                                     debe estar al final de la cadena
                    // \d debe corresponder a un dígito
                    // \w debe corresponer a una palabra
                    // +(char or expression) al menos una vez o muchas
                    // *(char or expression) zero o muchas
                    // . match any single character

                    // .* matchs anything, even empty string
                    // .+ matchs anything that contains at least one character
                    // ^\d+$ matchs any number that has at least one digit
                    echo "$path MATCHED";
                    return $this->executeController(
                        $route, $path, $info, $request
                    );
                }
            }
            $errorController = new ErrorController($this->di,$request);
            //Si ninguna de las rutas se adapta al Request envía el error
            return $errorController->notFound();
        }

        private function getRegexRoute(string $route, array $info): string{
            //Itera la lista de parámetros que viene de la información de la ruta ($info)
            //Para cada parámetro se reemplaza $route por la expresión que corresponde al tipo de parámetro
            //La ruta 'books/:id/borrow' se cambia a 'books/\d+/borrow
            if (isset($info['params'])){
                foreach($info['params'] as $name => $type){
                    $route = str_replace(
                        ':' . $name, self::$regexPatters[$type], $route
                    );
                }
            }
           return $route;
        }

        private function extractParams(
            //Para ejecutar el controlador se necesitan:
            //1) El nombre de la clase a instanciar (dentro de $info)
            //2) El nombre del método a ejecutar (dentro de $info)
            //3) Los parámetros para el método

            string $route,
            string $path
        ):array {
            $params = [];

            $pathParts= explode('/', $path);
            $routeParts= explode('/', $route);
            //Se espera que la ruta de la petición y la URL de la ruta sigan el mismo patrón
            //Con explode se obtienen dos arrays $pathParts $routeParts que deben concordar en cada una de sus entradas. 
            //Se iteran y por cada entrada de $route que sea como un parámetro se mete en la URL
            //Ejemplo: si tiene la ruta '/books/:id/borrow' y path '/books/12/borrow' el resultado sería el array ['id'=>12]

            foreach ($routeParts as $key => $routePart){
                if (strpos($routePart, ':')===0){
                    $name= substr($routePart,1);
                    $params[$name]=$pathParts[$key+1];
                }
            }
            return $params;
        }

        private function executeController(
            //Ejecuta el controlador para una ruta dada
            //Ya se tiene el nombre de la clase, el método y los argumentos y se usará call_user_func_array


            string $route,
            string $path,
            array $info,
            Request $request
        ): string{
            $controllerName= '\Bookstore\Controllers\\'.$info['controller'].'Controller';
            $controller= new $controllerName($this->di,$request);

            if(isset($info['login']) && $info['login']){
                if($request->getCookies()->has('user')){
                    $customerId= $request->getCookies()->get('user');
                    $controller->setCustomerId($customerId);
                }else{
                $errorController= new CustomerController($this->di,$request);
                //Si el usuario no tiene una cookie se ejecuta el método login
                return $errorController->login();
                }
            }
            $params = $this->extractParams($route, $path);
            return call_user_func_array([$controller, $info['method']],$params);
        }
        
    }
?>