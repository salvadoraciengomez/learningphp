<?php
    namespace Bookstore\Domain\Customer;

    class CustomerFactory{
        public static function factory(
            string $type,
            int $id,
            string $name,
            string $surname,
            string $email
        ): Customer{
            $classname = __NAMESPACE__ . '\\' . ucfirst($type);
            if(!class_exists($classname)){
                throw new \InvalidArgumentException('Wrong type.');
            }
            return new $classname($id, $name, $surname, $email);
        }
    }
?>