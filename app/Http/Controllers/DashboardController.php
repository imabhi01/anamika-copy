<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Expense;
use DB;

class DashboardController extends Controller
{
    private $invoicePaidLabels = [], 
        $invoiceUnPaidLabels = [],
        $invoicePaidDataCollection, 
        $invoiceUnPaidDataCollection,
        $expensePaidLabels,
        $expenseUnPaidLabels, 
        $expensePaidDataCollection, 
        $expenseUnPaidDataCollection,
        $months,
        $totalIncomeData,
        $totalExpensesData = []; 

    private $monthNames = ['Baisakh', 'Jestha', 'Ashar', 'Shrawan', 'Bhadra', 'Ashoj', 'Kartik', 'Mangsir', 'Poush', 'Magh', 'Falgun', 'Chaitra'];

    public function income(){
        $invoices = Invoice::select(
            DB::raw('sum(total) as `total`'), 'status',
            DB::raw("DATE_FORMAT(date,'%m') as months"),
        )
        ->where("date", ">", \Carbon\Carbon::now()->subMonths(6))
        ->groupBy('months', 'status')
        ->get();

        foreach($invoices as $invoiceDatum){
            if($invoiceDatum->status == 'Paid'){
                $monthName = $this->getMonthName($invoiceDatum->months);
                $this->invoicePaidLabels[] = $monthName;
                $this->invoicePaidDataCollection[] = intval($invoiceDatum->total);
            
            }

            if($invoiceDatum->status == 'Un paid'){
                $monthName = $this->getMonthName($invoiceDatum->months);
                $this->invoiceUnPaidLabels[] = $monthName;
                $this->invoiceUnPaidDataCollection[] = intval($invoiceDatum->total);
            }
        }

        return response()->json([
            'invoicePaidLabels' =>  $this->invoicePaidLabels,
            'invoicePaidDataCollection' => $this->invoicePaidDataCollection,
            'invoiceUnPaidLabels' => $this->invoiceUnPaidLabels,
            'invoiceUnPaidDataCollection' => $this->invoiceUnPaidDataCollection
        ]);
    }

    public function totalIncome(){
        $invoices = Invoice::select(
            DB::raw('max(status) as `status`'),
            DB::raw('sum(total) as `total`'),
            DB::raw("DATE_FORMAT(date,'%m') as months"),
        )
        ->where("date", ">", \Carbon\Carbon::now()->subMonths(6))
        ->groupBy('months')
        ->get();

        foreach($invoices as $invoiceDatum){
            $this->months[] = $this->getMonthName($invoiceDatum->months);
            $this->totalIncomeData[] = $invoiceDatum->total;
        }

        return response()->json([
            'months' =>  $this->months,
            'totalIncomeData' => $this->totalIncomeData
        ]);
    }
    
    public function totalExpense(){
        $expenses = Expense::select(
            DB::raw('max(status) as `status`'),
            DB::raw('sum(total) as `total`'),
            DB::raw("DATE_FORMAT(date,'%m') as months"),
        )
        ->where("date", ">", \Carbon\Carbon::now()->subMonths(6))
        ->groupBy('months')
        ->get();

        foreach($expenses as $expenseDatum){
            $this->months[] = $this->getMonthName($expenseDatum->months);
            $this->totalExpensesData[] = $expenseDatum->total;
        }

        return response()->json([
            'months' =>  $this->months,
            'totalExpensesData' => $this->totalExpensesData
        ]);
    }

    public function expense(){
        
        $expenses = Expense::select('status',
            DB::raw('sum(total) as `total`'),
            DB::raw("DATE_FORMAT(date,'%m') as months"),
        )
        ->where("date", ">", \Carbon\Carbon::now()->subMonths(6))
        ->groupBy('months', 'status')
        ->get();
        
        foreach($expenses as $expenseDatum){
            if($expenseDatum->status == 'Paid'){
                $this->expensePaidLabels[] = $this->getMonthName($expenseDatum->months);
                $this->expensePaidDataCollection[] = intval($expenseDatum->total);
            }

            if($expenseDatum->status == 'Un paid'){
                $this->expenseUnPaidLabels[] = $this->getMonthName($expenseDatum->months);
                $this->expenseUnPaidDataCollection[] = intval($expenseDatum->total);
            }
        }

        return response()->json([
            'expensePaidLabels' => $this->expensePaidLabels,
            'expensePaidDataCollection' => $this->expensePaidDataCollection,
            'expenseUnPaidLabels' => $this->expenseUnPaidLabels,
            'expenseUnPaidDataCollection' => $this->expenseUnPaidDataCollection
        ]);
    }

    public function getMonthName($date){
        switch($date){
            case 1: 
                return 'Baisakh';
                break;
            case 2: 
                return 'Jestha';
                break;
            case 3: 
                return 'Ashar';
                break;
            case 4: 
                return 'Shrawan';
                break;
            case 5: 
                return 'Bhadra';
                break;
            case 6:
                return 'Ashoj';
                break;
            case 7:
                return 'Kartik';
                break;
            case 8:
                return 'Mangsir';
                break;
            case 9:
                return 'Poush';
                break;
            case 10:
                return 'Magh';
                break;
            case 11:
                return 'Falgun';
                break;
            case 12:
                return 'Chaitra';
                break;
            default:
                return '';
                break;

        }
    }
}
