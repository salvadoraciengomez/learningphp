<?php
    namespace Bookstore\Models;

    use Bookstore\Domain\Book;
    use Bookstore\Exceptions\DbException;
    use Bookstore\Exceptions\NotFoundException;
    use PDO;

    class BookModel extends AbstractModel{
        //recibe PDO en el constructor y todas las propiedades se corresponden con las columnas SQL

        const CLASSNAME = '\Bookstore\Domain\Book';

        public function get(int $bookId): Book{
            $query = 'SELECT * FROM book WHERE id= :id';
            //$sth= $this->db->prepare($query);
            //$sth= $this->$db->prepare($query);
            $sth= parent::getDb()->prepare($query);
            $sth->execute(['id' => $bookId]);

            $books= $sth->fetchAll(
                PDO::FETCH_CLASS, self::CLASSNAME
            );

            if (empty($books)) throw new NotFoundException;

            return $books[0];

        }

        public function getAll(int $page, int $pageLength): array{
            //Devuelve array de libros para una página dada (paginador)
            $start = $pageLength * ($page -1);

            $query = 'SELECT * FROM book LIMIT :page, :length';
            $sth = $this->db->prepare($query);
            $sth->bindParam('page', $start, PDO::PARAM_INT);
            $sth->bindParam('length', $pageLength, PDO::PARAM_INT);
            $sth->execute();

            return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        }

        public function getByUser(int $userId): array{
            //devuelve libros que cierto cliente ha prestado
            $query= <<<SQL
                SELECT b.*
                FROM borrowed_books bb LEFT JOIN book b ON bb.book_id= b.id
                WHERE bb.customer_id= :idate
SQL;
            $sth= $this->db->prepare($query);
            $sth->execute(['id'=> $userId]);

            return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        }

        public function search(string $title, string $author):array{
            //Busca por título, autor o ambos
            $query= <<<SQL
                SELECT * FRFOM book
                WHERE title LIKE :title AND author LIKE :author
SQL;
            $sth = $this->db->prepare($query);
            $sth->bindValue('title', "%$title%");
            $sth->bindValue('author', "%$author%");
            $sth->execute();

            return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        }

        public function borrow(Book $book, int $userId){
            $query=<<<SQL
                INSERT INTO borrowed_books (book_id, customer_id, start)
                VALUES (:book, :user, NOW())
SQL;
            $sth= $this->db->prepare($query);
            $sth->bindValue('book', $book->getId());
            $sth->bindValue('user', $userId);

            if(!$sth->execute()) throw new DbException($sth->errorInfo()[2]);

            $this->updateBookStock($book);
        }

        public function returnBook(Book $book, int $userId){
            $query= <<<SQL
                UPDATE borrowed_books SET end = NOW()
                WHERE book_id= :book AND customer_id= :user AND end IS NULL
SQL;
            $sth= $this->db->prepare($query);
            $sth->bindValue('book', $book->getId());
            $sth->bindValue('user', $userId);

            if (!$sth->execute()) throw new DbException($sth->errorInfo()[2]);

            $this->updateBookStock($book);
        }

        private function updateBookStock(Book $book){
            $query = 'UPDATE book SET stock = :stock WHERE id= :id';
            $sth= $this->db->prepare($query);
            $sth->bindValue('stock', $book->getId());
            $sth->bindValue('stock', $book->getStock());

            if(!$sth->execute()) throw new DbException($sth->errorInfo()[2]);
        }
        
    }
?>