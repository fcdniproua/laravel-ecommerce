<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        Информация профиля
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Обновите информацию вашего профиля и email адрес.
                    </p>
                </header>

                <form wire:submit="updateProfile" class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="name" value="Имя" />
                        <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block bg-white w-full" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block bg-white w-full" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Сохранить</x-primary-button>

                        <x-action-message class="mr-3" on="profile-updated">
                            Сохранено.
                        </x-action-message>
                    </div>
                </form>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        Обновить пароль
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Убедитесь, что ваша учетная запись использует длинный, случайный пароль для обеспечения безопасности.
                    </p>
                </header>

                <form wire:submit="updatePassword" class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="current_password" value="Текущий пароль" />
                        <x-text-input wire:model="current_password" id="current_password" name="current_password" type="password" class="mt-1 bg-white block w-full" autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Новый пароль" />
                        <x-text-input wire:model="password" id="password" name="password" type="password" class="mt-1 bg-white  block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Подтвердите пароль" />
                        <x-text-input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block bg-white w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Сохранить</x-primary-button>

                        <x-action-message class="mr-3" on="password-updated">
                            Сохранено.
                        </x-action-message>
                    </div>
                </form>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        Удалить аккаунт
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        После удаления вашей учетной записи все ее ресурсы и данные будут удалены безвозвратно.
                    </p>
                </header>

                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="mt-6"
                >Удалить аккаунт</x-danger-button>

                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form wire:submit="deleteUser" class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            Вы уверены, что хотите удалить свой аккаунт?
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            После удаления вашей учетной записи все ее ресурсы и данные будут удалены безвозвратно.
                        </p>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                Отмена
                            </x-secondary-button>

                            <x-danger-button class="ml-3">
                                Удалить аккаунт
                            </x-danger-button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>
    </div>
</div>
