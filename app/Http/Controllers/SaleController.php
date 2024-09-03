<?php

namespace App\Http\Controllers;


use PDF;
use App\Interfaces\SaleInterface;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

use App\Models\sales_items;

class SaleController extends Controller
{



    //
    private SaleInterface $saleInterface;


    
    public function index()
    {
        // $data = $this->saleInterface->index();

        // return view('sales.index', [
        //     'page' => 'sales',
        //     'products' => $data
        // ]);

        $sales = Sale::all();

        //$sales = Sale::with('customer')->get();
        return view('sales.index', compact('sales'));
    }






    public function create()
    {

        $products = Product::all();


        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {

        $request->validate([

            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);


        $totalAmount = 0;
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);

            if ($product->quantity < $item['quantity']) {
                return back()->with("error", "Stock insuffisant pour le produit: {$product->name}");
            }else{
                $totalAmount += $product->price * $item['quantity'];
            }

            
        }

        $sale = Sale::create([
            'customer' => $request->customer,
            'total_amount' => $totalAmount,
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            sales_items::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);

            $product->decrement('quantity', $item['quantity']);
        }

        return redirect()->route('sales.show', $sale->id)->with('success', 'vente creer avec success');
    }

    public function show(Sale $sale)
    {
        return $this->generateInvoice($sale);
        // return view('sales.show', compact('sale'));
    }

    public function generateInvoice(Sale $sale)
    {
        $pdf = PDF::loadView('sales.invoice', compact('sale'));
        return $pdf->download('invoice.pdf');

        //    $html = view('sales.invoice', compact('sale'))->render();
        //    $mpdf = new Mpdf();
        //    $mpdf->WriteHTML($html);
        //    return $mpdf->Output('invoice.pdf', 'D');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        // Réajuster le stock des produits associés
        foreach ($sale->saleItems as $item) {
            $product = $item->product;
            $product->quantity += $item->quantity;
            $product->save();
        }

        // Supprimer la vente
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'vente suprimer avec succes.');
    }
}
