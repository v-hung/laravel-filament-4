<?php

namespace App\Livewire;

use App\Data\ProductSearchParams;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Livewire\Component;

class ProductList extends Component
{
    public array $paramArr = [];

    protected ProductSearchParams $params;

    protected $queryString = ['paramArr'];

    public function mount(Request $request): void
    {
        $this->params = ProductSearchParams::fromRequest($request);
        $this->paramArr = $this->params->toArray();
    }

    public function updating($name, $value): void
    {
        if ($name !== 'paramArr.page') {
            $this->paramArr['page'] = 1;
        }

        $this->params = ProductSearchParams::fromArray($this->paramArr);
    }

    public function render()
    {
        $this->params = ProductSearchParams::fromArray($this->paramArr);

        $products = ProductRepository::search($this->params);

        return view('livewire.product-list', [
            'products' => $products,
        ]);
    }
}
