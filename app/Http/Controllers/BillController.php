<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        return view('bill'); // or your view file name
    }
    
    public function calculatebill($customerName = "riza sotto", $customerType = "Lifeline",$consumptionKwh = 100)
    {
        $ratePerKwh = 0;
        $fixedCharge = 0;
        $discount = 0;
        $baseBill = 0;
        $totalBill = 0;

        switch (strtolower($customerType)) {
         case "lifeline":
                $ratePerKwh = 5.00;
                $fixedCharge = 0;
                $baseBill = $consumptionKwh * $ratePerKwh;
                $discount = 0.20 * $baseBill;
                $totalBill = $baseBill - $discount;
                break;

          case "regular":
                $ratePerKwh = 9.50;
                $fixedCharge = 50;
                $baseBill = $consumptionKwh * $ratePerKwh;
                $totalBill = $baseBill + $fixedCharge;
                break;

            case "commercial":
                $ratePerKwh = 12.00;
                $fixedCharge = 200;
                $baseBill = $consumptionKwh * $ratePerKwh;
                $discount = 0.05 * $baseBill;
                $totalBill = ($baseBill + $fixedCharge) - $discount;
                break;

            default:
             return[
                'error' => 'Invalid customer type. Please use Lifetime, Regular, or Commercial'
             ];
          
        }
        $baseBillFormatted = number_format($baseBill, 2);
        $totalBillFormatted = number_format($totalBill, 2);

        return[
            'customer_name'=> $customerName,
            'customer_type'=> $customerType,
            'Consumption_kwh'=> $consumptionKwh,
            'base_bill'=> $baseBillFormatted,
            'total_bill'=> $totalBillFormatted
        ];

    }

    public function showbill()
    {
        $bill = $this->calculatebill("Riza","Lifeline",100);

        return view('bill',compact('bill'));
    }
}

