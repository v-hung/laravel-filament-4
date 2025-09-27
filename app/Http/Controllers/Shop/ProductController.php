<?php

namespace App\Http\Controllers\Shop;

use App\Data\ProductSearchParams;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function shop(Request $request)
    {
        // use livewire component
        return parent::view();

        // $params = ProductSearchParams::fromRequest($request);

        // $products = ProductRepository::search($params);

        // return parent::view([
        //     'products' => $products
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        return parent::view();
    }
}
