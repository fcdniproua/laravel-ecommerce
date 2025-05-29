<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Управление товарами</h1>
        <button wire:click="createProduct"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Добавить товар
        </button>
    </div>

    <div class="mb-6">
        <div class="flex justify-around items-center">
            <div class="flex-1 pr-4">
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Поиск по названию или артикулу..."
                    class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="flex items-center space-x-4">
                <select wire:model.live="sortField" class="px-4 py-2 pr-8 border rounded-lg min-w-[150px] appearance-none bg-white bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em] cursor-pointer">
                    <option value="name">По названию</option>
                    <option value="price">По цене</option>
                    <option value="stock">По наличию</option>
                    <option value="created_at">По дате создания</option>
                </select>
                <select wire:model.live="sortDirection" class="px-4 py-2 pr-8 border rounded-lg min-w-[150px] appearance-none bg-white bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em] cursor-pointer">
                    <option value="asc">По возрастанию</option>
                    <option value="desc">По убыванию</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Изображение
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Название
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Артикул
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Цена
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Наличие
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Действия
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($product->image)
                                <img src="{{ Storage::url($product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">Нет фото</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $product->sku }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ number_format($product->price, 2) }} ₴
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->stock }} шт.
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="editProduct({{ $product->id }})"
                                class="text-blue-600 hover:text-blue-900 mr-4">
                                Редактировать
                            </button>
                            <button wire:click="deleteProduct({{ $product->id }})"
                                class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Вы уверены?')">
                                Удалить
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Товары не найдены
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

    @if ($showEditModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
                <h2 class="text-xl font-bold mb-6">
                    {{ $editingProduct ? 'Редактировать товар' : 'Добавить товар' }}
                </h2>

                <form wire:submit="save">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Название
                            </label>
                            <input wire:model="name" type="text"
                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Артикул
                            </label>
                            <input wire:model="sku" type="text"
                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3">
                            @error('sku')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Цена
                            </label>
                            <input wire:model="price" type="number" step="0.01"
                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Количество на складе
                            </label>
                            <input wire:model="stock" type="number"
                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Описание
                            </label>
                            <textarea wire:model="description" rows="3"
                                class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3"></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Изображение
                            </label>
                            <input wire:model="image" type="file" accept="image/*"
                                class="mt-1 block w-full">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" wire:click="$set('showEditModal', false)"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">
                            Отмена
                        </button>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            {{ $editingProduct ? 'Сохранить' : 'Создать' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
