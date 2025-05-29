<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div class="flex-1 pr-4">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Поиск по названию или артикулу..." class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="flex items-center space-x-4">
                <select wire:model.live="sortField" class="px-4 py-2 pr-8 border rounded-lg min-w-[150px] appearance-none bg-white bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em] cursor-pointer">
                    <option value="name">По названию</option>
                    <option value="price">По цене</option>
                    <option value="stock">По наличию</option>
                </select>
                <select wire:model.live="sortDirection" class="px-4 py-2 pr-8 border rounded-lg min-w-[150px] appearance-none bg-white bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em] cursor-pointer">
                    <option value="asc">По возрастанию</option>
                    <option value="desc">По убыванию</option>
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if ($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">Нет изображения</span>
                    </div>
                @endif

                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-2">Артикул: {{ $product->sku }}</p>
                    <p class="text-gray-800 font-bold mb-2">{{ number_format($product->price, 2) }} ₴</p>
                    <p class="text-sm text-gray-500 mb-4">
                        @if ($product->stock > 0)
                            В наличии: {{ $product->stock }} шт.
                        @else
                            Нет в наличии
                        @endif
                    </p>

                    @if ($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                class="w-20 px-2 py-1 border rounded mr-2">
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                В корзину
                            </button>
                        </form>
                    @else
                        <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded cursor-not-allowed">
                            Нет в наличии
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Товары не найдены</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
