<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Product Revenues
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <table class="min-w-full divide-y divide-gray-200 w-full table-fixed">
                    <thead>
                        <tr>
                            <th scope="col" width="50"
                                class="w-1/5 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th scope="col"
                                class="w-1/5 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Seller Name
                            </th>
                            <th scope="col"
                                class="w-1/5 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Units Sold
                            </th>
                            <th scope="col"
                                class="w-1/5 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Revenue
                            </th>
                            <th scope="col" width="200"
                                class="w-1/5 px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($revenues as $revenue)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    {{ $revenue->product->title }}
                                    @if ($revenue->product->deleted_at)
                                        <span class="text-xs text-red-800">- Deleted</span>
                                    @endif
                                    @if ($revenue->product->featured)
                                        <span class="text-xs text-yellow-800">- Featured</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    {{ $revenue->seller?->name ?? ($revenue->user?->name ?? '—') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    {{ ucfirst(number_format($revenue->units_sold)) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    {{ number_format($revenue->gross_revenue) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <a href="{{ route('product.show', $revenue->product) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="6">
                                    No Products revenues for now!!!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($revenues->count())
                    <div class="p-4">
                        {{ $revenues->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

</x-app-layout>
