<?php
    namespace Bookstore\Models;

    use Bookstore\Domain\Customer;
    use Bookstore\Domain\Customer\CustomerFactory;
    use Bookstore\Exceptions\NotFoundException;

    class CustomerModel extends AbstractModel{
        //Clase que en principio trabajará con clientes ya existentes en la BD
        public function get (int $userId):Customer{
            //Devuelve customer por ID mediante la consulta o lanza excepción
            $query = 'SELECT * FROM customer WHERE customer_id = :user';
            $sth= $this->db->prepare($query);
            $sth->execute(['user'=>$userId]);

            $row = $sth->fetch();

            if(empty($row)) throw new NotFoundException();

            return CustomerFactory::factory(
                $row['type'],
                $row['id'],
                $row['name'],
                $row['surname'],
                $row['email']
            );
        }

        public function getByEmail(string $email):Customer{
            //Devuelve Customer por 'email'
            $query= 'SELECT * FROM customer WHERE email= :user';
            $sth = parent::getDb()->prepare($query);
            $sth->execute(['user' => $email]);

            $row = $sth->fetch();

            if (empty($row)) throw new NotFoundException;

            return CustomerFactory::factory(
                $row['type'],
                $row['id'],
                $row['name'],
                $row['surname'],
                $row['email']
            );
        }
    }

?>