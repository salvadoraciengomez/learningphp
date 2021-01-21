<?php
    namespace Bookstore\Core;

    use Bookstore\Controllers\ErrorController;
    use Bookstore\Controllers\CustomerController;

    class Router{
        private $routeMap;
        private static $regexPatters=[
            'number' => '\d+',
            'string' => '\w'
        ];

        public function __construct(){
            //Al crear Router se lee el routes.json para comprobar si corresponde a algún controlador el objeto Request enviado al método route()
            $json = \file_get_contents( __DIR__ . '/../../config/routes.json');
            $this->routeMap= json_decode($json, true);
        }

        public function route(Request $request): string{
            //coge un objeto Request y devuelve una cadena que se recibirá al cliente. Comprueba todas las rutas hasta encontrar la propia y enviar al controlador
            $path = $request->getPath();
            foreach ($this->routeMap as $route => $info){
                $regexRoute = $this->getRegexRoute($route, $info);
                if (preg_match("@^/$regexRoute@",$path)){
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
                    return $this->executeController(
                        $route, $path, $info, $request
                    );
                }
            }
            $errorController = new ErrorController($request);
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
    }
?>