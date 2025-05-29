<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">Корзина</h1>

    @if (count($cart) > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Товар</th>
                        <th class="text-center py-2">Цена</th>
                        <th class="text-center py-2">Количество</th>
                        <th class="text-right py-2">Сумма</th>
                        <th class="text-right py-2">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $productId => $item)
                        <tr class="border-b">
                            <td class="py-4">
                                <div class="flex items-center">
                                    @if ($item['image'])
                                        <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" 
                                            class="w-16 h-16 object-cover rounded mr-4">
                                    @endif
                                    <span class="font-medium">{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td class="text-center py-4">{{ number_format($item['price'], 2) }} ₴</td>
                            <td class="text-center py-4">
                                <div class="flex items-center justify-center">
                                    <button wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] - 1 }})"
                                        class="text-gray-500 hover:text-gray-700 px-2">
                                        -
                                    </button>
                                    <span class="mx-2">{{ $item['quantity'] }}</span>
                                    <button wire:click="updateQuantity({{ $productId }}, {{ $item['quantity'] + 1 }})"
                                        class="text-gray-500 hover:text-gray-700 px-2">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td class="text-right py-4">
                                {{ number_format($item['price'] * $item['quantity'], 2) }} ₴
                            </td>
                            <td class="text-right py-4">
                                <button wire:click="removeItem({{ $productId }})"
                                    class="text-red-500 hover:text-red-700">
                                    Удалить
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right py-4 font-bold">Итого:</td>
                        <td class="text-right py-4 font-bold">{{ number_format($total, 2) }} ₴</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-8 flex justify-between items-center">
                <button wire:click="clearCart"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                    Очистить корзину
                </button>
                <a href="{{ route('checkout') }}"
                    class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                    Оформить заказ
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 mb-4">Ваша корзина пуста</p>
            <a href="{{ route('home') }}" 
                class="inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                Перейти к покупкам
            </a>
        </div>
    @endif
</div>
