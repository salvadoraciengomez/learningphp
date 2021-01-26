<?php
    namespace Bookstore\Controllers;

    use Bookstore\Domain\Sale;
    use Bookstore\Models\SaleModel;

    class SalesController extends AbstractController{
        public function add($id): string{
            $bookId = (int)$id;
            $salesModel = new SalesModel($this->db);

            $sale = new Sale();
            $sale->setCustomerId($this->customerId);
            $sale->addBook($bookId);

            try{
                $salesModel->create($sale);
            }catch (\Exception $e){
                $properties=[
                    'errorMesssage' => 'Error buying the book.'
                ];
                $this->log->error('Error buying book:'.$e->getMessage());
                return $this->render('error.twig', $properties);
            }

            return $this->getByUser();
        }

        public function getByUser(): string{
            $salesModel = new SaleModel($this->db);

            $sales = $salesModel->getByUser($this->$customerId);

            $properties = ['sales' => $sales];
            return $this->render('sales.twig', $properties);
        }

        public function get($saleId): string{
            $salesModel = new SaleModel($this->db);

            $sale= $salesModel->get($saleId);
            $properties = ['sale' => $sale];

            return $this->render('sale.twig', $properties);
        }
    }
?>