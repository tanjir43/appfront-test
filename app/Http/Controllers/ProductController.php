<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Contracts\Services\ProductServiceInterface;
use App\Contracts\Services\CurrencyServiceInterface;

class ProductController extends Controller
{
    protected ProductServiceInterface $productService;

    protected CurrencyServiceInterface $currencyService;

    public function __construct(
        ProductServiceInterface $productService,
        CurrencyServiceInterface $currencyService
    ) {
        $this->productService = $productService;
        $this->currencyService = $currencyService;
    }

    public function index(): View
    {
        $products       = $this->productService->getAllProducts();
        $exchangeRate   = $this->currencyService->getUsdToEurExchangeRate();

        return view('products.list', compact('products', 'exchangeRate'));
    }

    public function show(Request $request): View
    {
        $id = $request->route('product_id');
        $product = $this->productService->getProductById($id);
        $exchangeRate = $this->currencyService->getUsdToEurExchangeRate();

        return view('products.show', compact('product', 'exchangeRate'));
    }
}
