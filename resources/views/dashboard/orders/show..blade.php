<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ 'Order Items' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div>
                    <table>
                        <thead>
                            <tr>
                                <th class="text-left">Title</th>
                                <th class="text-left">Seller</th>
                                <th class="text-left">Price</th>
                                <th class="text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
