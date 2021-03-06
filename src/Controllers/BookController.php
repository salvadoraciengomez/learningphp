<?php
    namespace Bookstore\Controllers;

    use Bookstore\Models\BookModel;

    class BookController extends AbstractController{
        const PAGE_LENGTH = 10;

        public function getAllWithPage($page): string{
            $page = (int)$page;
            $bookModel = new BookModel(parent::getDb());

            $books = $bookModel->getAll($page, self::PAGE_LENGTH);

            $properties=[
                'books' => $books,
                'currentPage' => $page,
                'lastPage' => count($books) < self::PAGE_LENGTH
            ];
            $ruta= $this->request->getPath();
            $properties=['ruta'=> $ruta];
            return $this->render('books.twig', $properties);
        }

        public function getAll():string{
            return $this->getAllWithPage(1);
        }

        public function get(int $bookId): string{
            //$bookModel = new BookModel($this->db);
            $bookModel = new BookModel(parent::getDb());

            try{
                $book = $bookModel->get($bookId);
            }catch(\Exception $e){
                $this->log->error('Error getting book: '.$e->getMessage());
                $properties = ['errorMessage'=> "Book $bookId not found!"];
                return $this->render('error.twig', $properties);
            }
            $ruta= $this->request->getPath();
            $properties = ['book' => $book];
            $properties=['ruta'=> $ruta];
            return $this->render('book.twig', $properties);
        }

        public function getByUser(): string{
            $bookModel = new BookModel($this->db);

            $books = $bookModel->getByUser($this->customerId);
            $properties = [
                'books' => $books,
                'currentPage' => 1,
                'lastPage' => true
            ];
            $ruta= $this->request->getPath();
            $properties=['ruta'=> $ruta];
            return $this->render('books.twig', $properties);
        }

        public function search():string{
            $title = $this->request->getParams()->getString('title');
            $author = $this->request->getParams()->getString('author');

            $bookModel = new BookModel($this->db);
            $books = $bookModel->search($title, $author);

            $properties = [
                'books' => $books,
                'currentPage' => 1,
                'lastPage' => true
            ];
            $ruta= $this->request->getPath();
            $properties=['ruta'=> $ruta];
            return $this->render('books.twig', $properties);
        }
    }
?>