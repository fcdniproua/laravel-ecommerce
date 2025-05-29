<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public ?Order $selectedOrder = null;
    public bool $showOrderDetails = false;

    protected array $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function viewOrder(Order $order): void
    {
        $this->selectedOrder = $order->load('items.product');
        $this->showOrderDetails = true;
    }

    public function updateOrderStatus(Order $order, $status): void
    {
        if (array_key_exists($status, Order::$statuses)) {
            $order->update(['status' => $status]);
            session()->flash('success', 'Статус заказа обновлен');
        }
    }

    public function render(): View|Application|Factory
    {
        $orders = Order::query()
            ->with(['items.product'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('customer_name', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_email', 'like', '%' . $this->search . '%')
                        ->orWhere('id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.order-list', [
            'orders' => $orders,
            'statuses' => Order::$statuses
        ]);
    }
}
