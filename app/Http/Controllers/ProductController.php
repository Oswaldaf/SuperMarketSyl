<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Classes\ResponseClass;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
//use Intervention\Image\Facades\Image as InterventionImage;


class ProductController extends Controller
{
    private CategoryInterface $categoryInterface;
    private ProductInterface $productInterface;

    public function __construct(CategoryInterface $categoryInterface, ProductInterface $productInterface)
    {
        $this->categoryInterface = $categoryInterface;
        $this->productInterface = $productInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productInterface->index();

        return view('products.index', [
            'page' => 'products',
            'products' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryInterface->index();

        return view("products.create", [
            "page" => "products.create",
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {


        $request->validate([
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->image_file->extension();

        $request->image_file->storeAs('public/images', $imageName);

        $data = [
            "name" => $request->name,
            "category_id" => $request->category_id,
            "image_file" => $imageName,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "short_description" => $request->short_description,
            "long_description" => $request->long_description,

        ];

        DB::beginTransaction();





        try {
            $this->productInterface->store($data);
            DB::commit();

            return ResponseClass::success();
        } catch (\Throwable $th) {
            return ResponseClass::rollback();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
        $product = Product::find($id);;


        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image_file' => $product->image_file
        ]);

       

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = $this->categoryInterface->index();
        $product = $this->productInterface->show($id);
        return view('products.edit', [
            'page' => 'products',
            'product' => $product,
            'categories' => $categories

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {

        $request->validate([
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = Product::findOrFail($id);

        // Supprimer l'ancienne image du stockage
        Storage::delete('public/images/' . $image->stored_name);

        $originalName = $request->file('image_file')->getClientOriginalName();
        $storedName = time() . '_' . $originalName;

        // Redimensionner la nouvelle image


        // Enregistrer la nouvelle image redimensionnée dans le stockage

        $request->image_file->storeAs('public/images', $storedName);


        $data = [
            "name" => $request->name,
            "category_id" => $request->category_id,
            "image_file" => $storedName,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "short_description" => $request->short_description,
            "long_description" => $request->long_description,

        ];

        DB::beginTransaction();
        /* $categories = $this->categoryInterface->index();*/
        try {
            $this->productInterface->update($data, $id);
            DB::commit();

            /*  return view()[

                'categories' => $categories
            ];
            return view("products.update", [
                "page" => "products.update",
                "categories" => $categories,

            ]);*/
            $categories = $this->categoryInterface->index();


            return ResponseClass::success();
        } catch (\Throwable $th) {

            return ResponseClass::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productInterface->delete($id);
        return ResponseClass::success();
    }
}
