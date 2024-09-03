<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;
use App\Models\sale;
use App\Models\Sales_items;

class MainController extends Controller
{
    private CategoryInterface $categoryInterface;
    private ProductInterface $productInterface;

    public function __construct(CategoryInterface $categoryInterface, ProductInterface $productInterface)
    {
        $this->categoryInterface = $categoryInterface;
        $this->productInterface = $productInterface;
      
    }

    public function home() {

        $categories = count($this->categoryInterface->index());
        $products = count($this->productInterface->index());
        $sale_total = Sale::sum('total_amount');
        $sales = Sale::Count();
       
        return view('welcome', [
            "categories" => $categories,
            "products" => $products,
           "sales" =>$sales,
           "sale_total" =>$sale_total,
            "product_chart_by_category" => $this->productInterface->chartByCategory(),
            "chartBySale" => $this->productInterface->chartBySale(),
            "chartBilan" => $this->productInterface->chartBilan(),
            "chartCategoriesBilan" => $this->productInterface->chartCategoriesBilan()
          
        ]);
    }
}
