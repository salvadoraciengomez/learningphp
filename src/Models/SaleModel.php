<?php
    namespace Bookstore\Models;

    use Bookstore\Domain\Sale;
    use Bookstore\Exceptions\DbException;
    use Bookstore\Exceptions\NotFoundException;
    use PDO;

    class SaleModel extends AbstractModel{
        const CLASSNAME = 'Bookstore\Domain\Sale';

        public function getByUser(int $userId): array{
            $query= 'SELECT * FROM sale WHERE s.customer_id= :user';
            $sth=$this->db->prepare($query);
            $sth->execute(['user'=> $userId]);

            return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        }

        public function get(int $saleId): Sale{
            $query= 'SELECT * FROM sale WHERE id= :id';
            $sth = $this->db->prepare($query);
            $sth->execute(['id'=> $saleId]);
            $sales= $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

            if (empty($sales)) throw new NotFoundException('Sale not found');

            $sale= array_pop($sales);

            $query = <<<SQL
                SELECT b.id, b.title, b.author, b.price, sb.amount as stock, b.isbn
                FROM sale s
                LEFT JOIN sale_book sb ON s.id = sb.sale_id 
                LEFT JOIN book b ON sb.book_id = b.id 
                WHERE s.id = :id 
SQL;
            $sth= $this->db->prepare($query);
            $sth->execute(['id' => $saleId]);
            $books = $sth->fetchAll(
                PDO::FETCH_CLASS, BookModel::CLASSNAME
            );

            $sale->setBooks($books);
            return $sale;

        }
    }
?>