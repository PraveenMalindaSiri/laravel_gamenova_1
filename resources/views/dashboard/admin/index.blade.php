<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            All User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <thead>
                        <tr>
                            <th scope="col" width="50"
                                class="w-1/4 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col"
                                class="w-1/4 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="w-1/4 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" width="200"
                                class="w-1/4 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    {{ $user->name }}
                                    @if ($user->deleted_at)
                                        <span class="text-xs text-red-800">- Banned</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    {{ strtoupper($user->role) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <a href="{{ route('users.show', $user->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Details</a>

                                    @if ($user->trashed())
                                        <form class="inline-block" action="{{ route('users.restore', $user->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to restore this user?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="submit" class="text-green-600 hover:text-green-900 mb-2 mr-2"
                                                value="Restore">
                                        </form>
                                    @else
                                        @if (!$user->isAdmin())
                                            {{-- Change pass --}}
                                            <a href="{{ route('users.edit', $user) }}"
                                                class="text-green-600 hover:text-green-900 mb-2 mr-2">Manage</a>

                                            {{-- Ban --}}
                                            <form class="inline-block" action="{{ route('users.destroy', $user) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to ban this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2"
                                                    value="Ban">
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="4">
                                    No Users in the system
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>
    </div>

</x-app-layout>
