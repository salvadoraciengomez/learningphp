<?php
    namespace Bookstore\Tests\Domain\Customer;

    use Bookstore\Domain\Customer\Basic;
    use PHPUnit_Framework_TestCase;

    class BasicTest extends PHPUnit_Framework_TestCase{
        
        public function testAmountToBorrow(){ //Los métodos que empiezan por "test" son los que ejecuta PHPUnit
            
            $customer = new Basic (1, 'han', 'solo', 'han@solo.com');
            
            //Para comprueba los dos primeros parámetros
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
    }

/**
 *  @test
 */
//public function thisIsATestToo(){}
//Convierte nombres de métodos que no empiecen por test en funciones de comprobación PHPUnit

//Para ejecutar test se hace uso del binario ./vendor/bin/phpunit

?>