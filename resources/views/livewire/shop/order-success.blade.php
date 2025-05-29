<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto text-center">
        <div class="mb-8">
            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-4">
            Спасибо за заказ!
        </h1>

        <p class="text-lg text-gray-600 mb-8">
            Ваш заказ #{{ $order->id }} успешно оформлен.
            Мы отправили подтверждение на {{ $order->customer_email }}.
        </p>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Детали заказа</h2>
            
            <div class="grid grid-cols-2 gap-4 text-left mb-6">
                <div>
                    <p class="text-gray-600">Способ доставки:</p>
                    <p class="font-medium">
                        {{ $order->shipping_method === 'pickup' ? 'Самовывоз' : 'Почтовая доставка' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-600">Способ оплаты:</p>
                    <p class="font-medium">
                        {{ $order->payment_method === 'cod' ? 'Наложенный платеж' : 'Онлайн оплата' }}
                    </p>
                </div>
            </div>

            <div class="border-t pt-4">
                <p class="text-gray-600">Сумма заказа:</p>
                <p class="text-2xl font-bold">{{ number_format($order->total_amount, 2) }} ₴</p>
            </div>
        </div>

        <div class="space-x-4">
            <a href="{{ route('home') }}" 
                class="inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                Вернуться к покупкам
            </a>
        </div>
    </div>
</div> 