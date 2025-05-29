<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">Оформление заказа</h1>

    @if (count($cart) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-6">Данные покупателя</h2>
                
                <form wire:submit="createOrder">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customerName">
                            ФИО
                        </label>
                        <input wire:model="customerName" type="text" id="customerName"
                            class="w-full px-3 py-2 border rounded @error('customerName') border-red-500 @enderror">
                        @error('customerName')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customerEmail">
                            Email
                        </label>
                        <input wire:model="customerEmail" type="email" id="customerEmail"
                            class="w-full px-3 py-2 border rounded @error('customerEmail') border-red-500 @enderror">
                        @error('customerEmail')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customerPhone">
                            Телефон
                        </label>
                        <input wire:model="customerPhone" type="tel" id="customerPhone"
                            class="w-full px-3 py-2 border rounded @error('customerPhone') border-red-500 @enderror">
                        @error('customerPhone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Способ доставки
                        </label>
                        <div class="mt-2 space-y-2">
                            <label class="inline-flex items-center">
                                <input wire:model="shippingMethod" type="radio" value="pickup" class="form-radio">
                                <span class="ml-2">Самовывоз</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input wire:model="shippingMethod" type="radio" value="postal" class="form-radio">
                                <span class="ml-2">Почтовая доставка</span>
                            </label>
                        </div>
                        @error('shippingMethod')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Способ оплаты
                        </label>
                        <div class="mt-2 space-y-2">
                            <label class="inline-flex items-center">
                                <input wire:model="paymentMethod" type="radio" value="cod" class="form-radio">
                                <span class="ml-2">Наложенный платеж</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input wire:model="paymentMethod" type="radio" value="online" class="form-radio">
                                <span class="ml-2">Онлайн оплата</span>
                            </label>
                        </div>
                        @error('paymentMethod')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="w-full bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600 transition">
                        Подтвердить заказ
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-6">Ваш заказ</h2>
                
                <div class="space-y-4">
                    @foreach ($cart as $productId => $item)
                        <div class="flex justify-between items-center border-b pb-4">
                            <div>
                                <h3 class="font-medium">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ number_format($item['price'], 2) }} ₴ × {{ $item['quantity'] }}
                                </p>
                            </div>
                            <span class="font-medium">
                                {{ number_format($item['price'] * $item['quantity'], 2) }} ₴
                            </span>
                        </div>
                    @endforeach

                    <div class="flex justify-between items-center pt-4 font-bold">
                        <span>Итого:</span>
                        <span>{{ number_format($total, 2) }} ₴</span>
                    </div>
                </div>
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
