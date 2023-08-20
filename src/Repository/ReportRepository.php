<?php

namespace App\Repository;

use PDO;

class ReportRepository extends BaseRepository
{
    public function report_salesProduct(): ?array
    {
        $query = $this->get_bbdd()->prepare('SELECT s.id, sp.id_product, sp.id_sale, p.description, sp.quantity, (sp.quantity * sp.price) as amount,sp.sale_product_date, sp.type_payment 
            FROM sales_product sp
            JOIN sales s 
            ON s.id = sp.id_sale
            JOIN  product p 
            ON p.id = sp.id_product 
            WHERE sp.active = 0 
            ORDER BY sp.sale_product_date DESC');
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $salesProduct = $query->fetchAll();

        if (!$salesProduct) {
            return null;
        }

        return $salesProduct;
    }

    public function report_expenses(int $month, int $year): ?float
    {
        $query = $this->get_bbdd()->prepare('SELECT COALESCE(SUM(e.price), 0)
            FROM expense e
            WHERE MONTH(e.date_expense)= :month AND YEAR(e.date_expense)= :year ');

        $query->bindParam(':month', $month);
        $query->bindParam(':year', $year);
        $query->execute();

        $expenses = $query->fetch();

        if (!$expenses) {
            return null;
        }

        return $expenses[0];
    }
    public function report_incomes(int $month, int $year): ?float
    {
        $query = $this->get_bbdd()->prepare('SELECT COALESCE(SUM(sp.price*sp.quantity), 0)
            FROM sales_product sp 
            JOIN sales s 
            ON s.id = sp.id_sale
            JOIN  product p 
            ON p.id = s.id_product
            WHERE MONTH(sp.sale_product_date)= :month AND YEAR(sp.sale_product_date)= :year ');

        $query->bindParam(':month', $month);
        $query->bindParam(':year', $year);
        $query->execute();

        $incomes = $query->fetch();

        if (!$incomes) {
            return null;
        }

        return $incomes[0];
    }
}
