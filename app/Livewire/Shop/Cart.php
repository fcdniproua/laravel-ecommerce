<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Cart extends Component
{
    public $cart = [];
    public $total = 0;

    public function mount()
    {
        $this->cart = session('cart', []);
        $this->calculateTotal();
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeItem($productId);
            return;
        }

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] = $quantity;
            session(['cart' => $this->cart]);
            $this->calculateTotal();
        }
    }

    public function removeItem($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            session(['cart' => $this->cart]);
            $this->calculateTotal();
        }
    }

    public function clearCart()
    {
        $this->cart = [];
        session()->forget('cart');
        $this->total = 0;
    }

    private function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $item) {
            $this->total += $item['price'] * $item['quantity'];
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.shop.cart');
    }
}
