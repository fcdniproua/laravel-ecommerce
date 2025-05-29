<?php

namespace App\Livewire\Shop;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Checkout extends Component
{
    public $cart = [];
    public $total = 0;
    
    public $customerName = '';
    public $customerEmail = '';
    public $customerPhone = '';
    public $shippingMethod = 'postal';
    public $paymentMethod = 'cod';

    public function mount()
    {
        if (auth()->check()) {
            $this->customerName = auth()->user()->name;
            $this->customerEmail = auth()->user()->email;
        }

        $this->cart = session('cart', []);
        if (empty($this->cart)) {
            return redirect()->route('home');
        }

        $this->calculateTotal();
    }

    public function createOrder()
    {
        $this->validate([
            'customerName' => 'required|min:3',
            'customerEmail' => 'required|email',
            'customerPhone' => 'required',
            'shippingMethod' => 'required|in:pickup,postal',
            'paymentMethod' => 'required|in:cod,online'
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'new',
            'total_amount' => $this->total,
            'customer_name' => $this->customerName,
            'customer_email' => $this->customerEmail,
            'customer_phone' => $this->customerPhone,
            'shipping_method' => $this->shippingMethod,
            'payment_method' => $this->paymentMethod
        ]);

        foreach ($this->cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        session()->forget('cart');
        
        return redirect()->route('order.success', $order);
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
        return view('livewire.shop.checkout');
    }
}
