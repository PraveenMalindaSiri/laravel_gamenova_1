<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ $panel === 'admin' ? 'All Order' : 'My Orders' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 w-full table-fixed">
                    <thead>
                        <tr>
                            <th scope="col" class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th scope="col" class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th scope="col" class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Price
                            </th>
                            <th scope="col" class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order Date
                            </th>
                            <th scope="col" class="w-1/5 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->id }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 truncate">
                                    {{ $order->user->name }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rs.{{ number_format($order->totalprice, 2) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->orderdate->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <a href="{{ route('orders.show', $order) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
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
