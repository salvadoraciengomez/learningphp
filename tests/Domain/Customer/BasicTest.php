<?php
    namespace Bookstore\Tests\Domain\Customer;

    use Bookstore\Domain\Customer\Basic;
    use PHPUnit_Framework_TestCase;

    class BasicTest extends PHPUnit_Framework_TestCase{

        private $customer;
        
        public function setUp(){
            //Establecimiento de prueba de uso con contexto generalizado (se ejecuta cada vez que inicia el test, como las funciones test)
            //Cuando testAmountToBorrow se ejecuta, la variable customer se encontrará inicializada porque previamente hace el setUp
            //Se vuelve a ejecutar setUp() para cada test
            //Se puede hacer uso del método tearDown() que se ejecutará al final del método testX()

            $this->customer = new Basic (1,'han','solo','han@solo.com');
        }
        
        public function testAmountToBorrow(){ //Los métodos que empiezan por "test" son los que ejecuta PHPUnit
            
            $customer = new Basic (1, 'han', 'solo', 'han@solo.com');
            
            //Para comprueba los dos primeros parámetros si son iguales
            $this->assertSame(
                3,
                $customer->getAmountToBorrow(),
                'Basic customer should borrow up to 3 books.'//Lo muestra en caso de fallo
            );
        }

        public function testFail(){

            $customer = new Basic (1,'han','solo','han@solo.com');

            $this->assertSame(
                4,
                $customer= testAmountToBorrow(),
                'Basic customer should borrow up to 3 books.'
            );
        }

        public function testIsExemptOfTaxes(){
            //Se asegura de que un basicCustomer nuca esté exento de tasas, se podría hacer con assertSame isExemptOfTaxes(),false
                $this->assertFalse(
                    isExemptOfTaxes(),
                    false,
                    'Basic customer should be exempt of taxes'
                );
        }

        public function testGetMonthlyFee(){
            $this->assertSame(
                5,
                $this->customer->testGetMonthlyFee(),
                'Basic customer should pay 5 a month.'
            );
        }
    }

/**
 *  @test
 */
//public function thisIsATestToo(){}
//Convierte nombres de métodos que no empiecen por test en funciones de comprobación PHPUnit

//Para ejecutar test se hace uso del binario ./vendor/bin/phpunit desde el directorio raíz
//Falla la ejecución de test unitarios (XDebug enabled?)

?>