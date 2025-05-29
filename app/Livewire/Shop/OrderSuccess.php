<?php

namespace App\Livewire\Shop;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;

class OrderSuccess extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.shop.order-success');
    }
} 