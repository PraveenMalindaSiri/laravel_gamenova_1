<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Change User Password
        </h2>
    </x-slot>


    @if ($user->trashed())
        <div class="p-3 bg-yellow-50 text-yellow-800 rounded">This user is banned. Restore before changing the password.
        </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-6">

                    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 grid grid-cols-2 gap-4">

                            <div class="col-span-2 text-xl">
                                Change the currect password of the user, {{ $user->name }}
                            </div>

                            <div class="col-span-2">
                                <x-input-field name="admin_password" label="Admin Password" :value="old('admin_password')"
                                    type="password" />
                            </div>

                            {{-- New Pass --}}
                            <div>
                                <x-input-field name="password" label="User New Password" :value="old('password')" type="password" />
                            </div>

                            {{-- Confirm Pass --}}
                            <div>
                                <x-input-field name="password_confirmation" label="Confirm New Password" :value="old('password_confirmation')"
                                    type="password" />
                            </div>

                        </div>

                        <x-button class="ms-4">
                            {{ 'Update' }}
                        </x-button>
                    </form>

                </div>
            </div>
        </div>
    @endif

</x-app-layout>
