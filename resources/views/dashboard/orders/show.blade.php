<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ 'Order Items' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 w-full table-fixed">
                    <thead>
                        <tr>
                            <th scope="col" width="50"
                                class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Game
                            </th>
                            <th scope="col" width="50"
                                class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th scope="col"
                                class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col"
                                class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Digital Code - Digital Editions ONLY
                            </th>
                            <th scope="col" width="200" class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orderItems as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->product->title }}
                                    @if ($order->product->deleted_at)
                                        <span class="text-xs text-red-800">- Deleted</span>
                                    @endif
                                    @if ($order->product->featured)
                                        <span class="text-xs text-yellow-800">- Featured</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->quantity }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->price }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->digitalcode ?? '---' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('product.show', $order->product) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">View Product</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    No Orders in the system
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>


</x-app-layout>
