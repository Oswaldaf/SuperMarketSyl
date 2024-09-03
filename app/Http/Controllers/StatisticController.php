<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ProductInterface;
use App\Models\Sale;
use Carbon\Carbon; 

class StatisticController extends Controller
{
    //
    private ProductInterface $productInterface;

    public function __construct(ProductInterface $productInterface)
    {

        $this->productInterface = $productInterface;
    }


    public function index()
    {


        return view('statistic.index', [
            'page' => 'statistic.index',
            "product_chart_by_category" => $this->productInterface->chartByCategory(),
            "chartBySale" => $this->productInterface->chartBySale(),


        ]);
    }

    public function salesReport(Request $request)
    {
        
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $sales = Sale::whereBetween('created_at', [$startDate, $endDate])->get();

        return view('statistic.report', compact('sales', 'startDate', 'endDate'));
    


        //ggg

     
       
    }

    public function stat1()
    {


        return view('statistic.categoriesStat', [
            'page' => 'statistic.categoriesStat'

        ]);
    }


    public function stat2()
    {


        return view('statistic.anneeStat', [
            'page' => 'statistic.anneeStat'

        ]);
    }


    public function stat3()
    {


        return view('statistic.chiffreStat', [
            'page' => 'statistic.chiffreStat'

        ]);
    }

    public function stat4()
    {


        return view('statistic.bilan', [
            'page' => 'statistic.bilan'

        ]);
    }
}
