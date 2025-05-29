<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProductList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    // Form fields
    public $editingProduct = null;
    public $name = '';
    public $price = '';
    public $description = '';
    public $stock = '';
    public $sku = '';
    public $image;
    public $showEditModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'stock' => 'required|integer|min:0',
        'sku' => 'required|string|unique:products,sku',
        'image' => 'nullable|image|max:1024',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function editProduct(Product $product)
    {
        $this->editingProduct = $product;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->description = $product->description;
        $this->stock = $product->stock;
        $this->sku = $product->sku;
        $this->showEditModal = true;
    }

    public function createProduct()
    {
        $this->resetForm();
        $this->editingProduct = null;
        $this->showEditModal = true;
    }

    public function save()
    {
        if ($this->editingProduct) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'stock' => $this->stock,
            'sku' => $this->sku,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('products', 'public');
        }

        Product::create($data);
        $this->resetForm();
        $this->showEditModal = false;
        session()->flash('success', 'Товар успешно создан');
    }

    public function update()
    {
        $rules = $this->rules;
        $rules['sku'] = 'required|string|unique:products,sku,' . $this->editingProduct->id;
        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'stock' => $this->stock,
            'sku' => $this->sku,
        ];

        if ($this->image) {
            if ($this->editingProduct->image) {
                Storage::disk('public')->delete($this->editingProduct->image);
            }
            $data['image'] = $this->image->store('products', 'public');
        }

        $this->editingProduct->update($data);
        $this->resetForm();
        $this->showEditModal = false;
        session()->flash('success', 'Товар успешно обновлен');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        session()->flash('success', 'Товар успешно удален');
    }

    private function resetForm()
    {
        $this->editingProduct = null;
        $this->name = '';
        $this->price = '';
        $this->description = '';
        $this->stock = '';
        $this->sku = '';
        $this->image = null;
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.product-list', [
            'products' => $products
        ]);
    }
}
