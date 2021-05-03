<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(){
        \Gate::authorize("view","products");
        return ProductResource::collection(Product::paginate());
    }
    public function show($id){
        \Gate::authorize("view","products");
        $product = Product::find($id);
        return new ProductResource($product);
    }
    public function store(Request $req){
        \Gate::authorize("edit","products");
        $product = Product::create(
            $req->only("title","description","image","price")
        );
        return response(new ProductResource($product),Response::HTTP_CREATED);
    }
    public function update(Request $req,$id){
        \Gate::authorize("edit","products");
        $product = Product::find($id);
        $product->update(
            $req->only("title","description","image","price")
        );
        return response(new ProductResource($product),Response::HTTP_ACCEPTED);
    }
    public function destroy($id){
        \Gate::authorize("edit","products");
        Product::destroy($id);
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
