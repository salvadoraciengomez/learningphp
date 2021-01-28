<?php
    namespace Bookstore\Test\Domain\Customer;

    use Bookstore\Domain\Customer\CustomerFactory;
    use PHPUnit_Framework_TestCase;

    class CustomerFactoryTest extends PHPUnit_Framework_TestCase{

        public function testFactoryBasic(){
            $customer = CustomerFactory::factory(
                'basic',1,'han','solo','han@solo.com'
            );

            $this->assertInstanceOf(
                //comprueba si pertenece a una clase
                Basic::class,
                $customer,
                'basic should create a Customer\Basic object'
            );
        }
    }
?>