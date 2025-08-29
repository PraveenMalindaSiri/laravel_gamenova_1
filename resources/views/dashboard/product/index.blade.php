<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ $panel === 'admin' ? 'All Products' : 'My Products' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <thead>
                        <tr>
                            <th scope="col" width="50"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Platform
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Genre
                            </th>
                            <th scope="col" width="200" class="py-3 bg-gray-50">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $product->title }}
                                    @if ($product->deleted_at)
                                        <span class="text-xs text-red-800">- Deleted</span>
                                    @endif
                                    @if ($product->featured)
                                        <span class="text-xs text-yellow-800">- Featured</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $product->price }}
                                </td>


                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ucfirst($product->type) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ucfirst($product->platform) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $product->genre }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('product.show', $product) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">View</a>

                                    @if (!$product->deleted_at)
                                        <a href="{{ route('myproducts.edit', $product) }}"
                                            class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Edit</a>

                                        <form class="inline-block" action="{{ route('myproducts.destroy', $product) }}"
                                            method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="text-red-600 hover:text-red-900 mb-2"
                                                value="Delete">
                                        </form>
                                    @else
                                        <form class="inline-block" action="{{ route('myproducts.restore', $product) }}"
                                            method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="submit" class="text-green-600 hover:text-green-900 mb-2"
                                                value="ACTIVATE">
                                        </form>
                                    @endif

                                    @if (Auth::user()->isAdmin())
                                        <form class="inline-block ml-2" action="{{ route('feature.update', $product) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            @if ($product->featured)
                                                <input type="hidden" name="featured" value="0">
                                                <input type="submit" class="text-yellow-700 hover:text-yellow-900 mb-2"
                                                    value="Unfeature">
                                            @else
                                                <input type="hidden" name="featured" value="1">
                                                <input type="submit" class="text-green-600 hover:text-green-900 mb-2"
                                                    value="Feature">
                                            @endif
                                        </form>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="6">
                                    No Products in the system
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>
    </div>

</x-app-layout>
