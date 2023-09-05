<?php

namespace App\Service;

use App\DTO\Reportes\ReportIncomesExpensesDTO;
use App\Repository\ReportRepository;

class ReportService
{
    protected $rep_report;

    public function __construct(ReportRepository $rep_report)
    {
        $this->rep_report = $rep_report;
    }

    public function report_salesProduct(int $id_negocio)
    {
        return $this->rep_report->report_salesProduct($id_negocio);
    }
    public function report_incomes_expenses(int $month, int $year, $id_negocio): ReportIncomesExpensesDTO
    {
        $expenses = $this->rep_report->report_expenses($month, $year, $id_negocio);
        $incomes = $this->rep_report->report_incomes($month, $year, $id_negocio);
        $reponse = new ReportIncomesExpensesDTO($incomes, $expenses, ($incomes - $expenses));
        return $reponse;
    }
}
