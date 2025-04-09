<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @var ProductServiceInterface
     */
    protected ProductServiceInterface $productService;

    /**
     * AdminProductController constructor.
     *
     * @param ProductServiceInterface $productService
     */
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of products for admin.
     *
     * @return View
     */
    public function index(): View
    {
        $products = $this->productService->getAllProducts();

        return view('admin.products', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.add_product');
    }

    /**
     * Store a newly created product.
     *
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $image = $request->hasFile('image') ? $request->file('image') : null;

        $this->productService->createProduct($validatedData, $image);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Product added successfully');
    }

    /**
     * Show the form for editing a product.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $product = $this->productService->getProductById($id);

        return view('admin.edit_product', compact('product'));
    }

    /**
     * Update the specified product.
     *
     * @param UpdateProductRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $image = $request->hasFile('image') ? $request->file('image') : null;

        $this->productService->updateProduct($id, $validatedData, $image);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified product.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->productService->deleteProduct($id);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Product deleted successfully');
    }
}
