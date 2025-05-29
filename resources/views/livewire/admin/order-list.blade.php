<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Управление заказами</h1>
    </div>

    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div class="flex-1 pr-4">
                <input wire:model.live.debounce.300ms="search" type="text" 
                    placeholder="Поиск по имени, email или номеру заказа..." 
                    class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="flex items-center space-x-4">
                <select wire:model.live="status" class="px-4 py-2 pr-8 border rounded-lg min-w-[150px] appearance-none bg-white bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em] cursor-pointer" style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3E%3Cpath stroke=\'%236B7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'m6 8 4 4 4-4\'/%3E%3C/svg%3E')">
                    <option value="">Все статусы</option>
                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                <select wire:model.live="sortField" class="px-4 py-2 pr-8 border rounded-lg min-w-[150px] appearance-none bg-white bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em] cursor-pointer" style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3E%3Cpath stroke=\'%236B7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'m6 8 4 4 4-4\'/%3E%3C/svg%3E')">
                    <option value="created_at">По дате</option>
                    <option value="total_amount">По сумме</option>
                    <option value="status">По статусу</option>
                </select>
                <select wire:model.live="sortDirection" class="px-4 py-2 pr-8 border rounded-lg min-w-[150px] appearance-none bg-white bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em] cursor-pointer" style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3E%3Cpath stroke=\'%236B7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'m6 8 4 4 4-4\'/%3E%3C/svg%3E')">
                    <option value="desc">По убыванию</option>
                    <option value="asc">По возрастанию</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        № Заказа
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Клиент
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Сумма
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Статус
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Дата
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Действия
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            #{{ $order->id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="font-medium text-gray-900">{{ $order->customer_name }}</div>
                                <div class="text-gray-500">{{ $order->customer_email }}</div>
                                <div class="text-gray-500">{{ $order->customer_phone }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ number_format($order->total_amount, 2) }} ₴
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select wire:change="updateOrderStatus({{ $order->id }}, $event.target.value)"
                                class="text-sm border rounded-full px-3 py-1 pr-8 min-w-[120px] appearance-none bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em] cursor-pointer
                                    {{ $order->status === 'new' ? 'bg-yellow-100 text-yellow-800 border-yellow-200' :
                                       ($order->status === 'processing' ? 'bg-blue-100 text-blue-800 border-blue-200' :
                                        'bg-green-100 text-green-800 border-green-200') }}"
                                style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3E%3Cpath stroke=\'%236B7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'m6 8 4 4 4-4\'/%3E%3C/svg%3E')">
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="viewOrder({{ $order->id }})"
                                class="text-blue-600 hover:text-blue-900">
                                Детали
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Заказы не найдены
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>

    @if ($showOrderDetails)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-bold">Заказ #{{ $selectedOrder->id }}</h2>
                        <p class="text-gray-500">{{ $selectedOrder->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <button wire:click="$set('showOrderDetails', false)" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-semibold mb-2">Информация о клиенте</h3>
                        <p>{{ $selectedOrder->customer_name }}</p>
                        <p>{{ $selectedOrder->customer_email }}</p>
                        <p>{{ $selectedOrder->customer_phone }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Информация о доставке</h3>
                        <p>Способ доставки: {{ $selectedOrder->shipping_method === 'pickup' ? 'Самовывоз' : 'Почтовая доставка' }}</p>
                        <p>Способ оплаты: {{ $selectedOrder->payment_method === 'cod' ? 'Наложенный платеж' : 'Онлайн оплата' }}</p>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="font-semibold mb-4">Товары в заказе</h3>
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Товар</th>
                                <th class="text-center py-2">Цена</th>
                                <th class="text-center py-2">Количество</th>
                                <th class="text-right py-2">Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selectedOrder->items as $item)
                                <tr class="border-b">
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            @if ($item->product->image)
                                                <img src="{{ Storage::url($item->product->image) }}" 
                                                    alt="{{ $item->product->name }}" 
                                                    class="w-12 h-12 object-cover rounded mr-4">
                                            @endif
                                            <span>{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center py-4">{{ number_format($item->price, 2) }} ₴</td>
                                    <td class="text-center py-4">{{ $item->quantity }}</td>
                                    <td class="text-right py-4">{{ number_format($item->price * $item->quantity, 2) }} ₴</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right py-4 font-bold">Итого:</td>
                                <td class="text-right py-4 font-bold">{{ number_format($selectedOrder->total_amount, 2) }} ₴</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
