<?php

namespace App\Livewire;

use App\Data\ProductSearchParams;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Livewire\Component;

class ProductList extends Component
{
    public ProductSearchParams $params;
    private $paramArr = [];

    protected $queryString = ['paramArr'];

    public function mount(Request $request)
    {
        $this->params = ProductSearchParams::fromRequest($request);
        $this->paramArr = get_object_vars($this->params);
    }

    public function updating($name, $value)
    {
        if (!in_array($name, ['params.page'])) {
            $this->params->page = 1;
        }
        $this->paramArr = get_object_vars($this->params);

        // // So sánh từng key ngoại trừ 'page'
        // foreach ($current as $key => $value) {
        //     if ($key !== 'page' && ($this->oldParams[$key] ?? null) !== $value) {
        //         // Filter thay đổi → reset page
        //         $this->params->page = 1;
        //         break;
        //     }
        // }

        // // Cập nhật snapshot
        // $this->oldParams = $current;
    }

    // public function updatingParams()
    // {
    // }

    public function render()
    {
        $products = ProductRepository::search($this->params);

        return view('livewire.product-list', [
            'products' => $products
        ]);
    }
}
