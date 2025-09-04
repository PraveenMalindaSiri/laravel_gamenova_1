<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            User Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Information -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="p-6 lg:p-8 bg-white  ">
                    <div class="grid grid-cols-4 gap-6">
                        <!-- Profile Photo -->
                        <div class="col-span-full">
                            <x-label for="photo" value="{{ __('Photo') }}" />
                            <div class="mt-2">
                                <img class="rounded-full h-20 w-20 object-cover" src="{{ $user->profile_photo_url }}"
                                    alt="{{ $user->name }}" />
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="col-span-2">
                            <x-label for="name" value="{{ __('Name') }}" />
                            <div class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                                {{ $user->name }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-span-2">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <div class="mt-1 block w-full px-3 py-2  border border-gray-300 rounded-md text-gray-900">
                                {{ $user->email }}
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <x-label for="role" value="{{ __('Role') }}" />
                            <div class="mt-1 block w-full px-3 py-2  border border-gray-300 rounded-md text-gray-900">
                                {{ ucfirst($user->role) }}
                            </div>
                        </div>

                        <!-- Dob -->
                        <div>
                            <x-label for="dob" value="{{ __('Date of Birth') }}" />
                            <div class="mt-1 block w-full px-3 py-2  border border-gray-300 rounded-md text-gray-900">
                                {{ ucfirst($user->dob ?? 'Not provided') }}
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <x-label for="address" value="{{ __('Address') }}" />
                            <div class="mt-1 block w-full px-3 py-2  border border-gray-300 rounded-md text-gray-900">
                                {{ ucfirst($user->address ?? 'Not provided') }}
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-label for="phone" value="{{ __('Phone no.') }}" />
                            <div class="mt-1 block w-full px-3 py-2  border border-gray-300 rounded-md text-gray-900">
                                {{ ucfirst($user->phone ?? 'Not provided') }}
                            </div>
                        </div>

                        <!-- Email Verified At -->
                        <div>
                            <x-label for="email_verified_at" value="{{ __('Email Verified') }}" />
                            <div class="mt-1 block w-full px-3 py-2  border border-gray-300 rounded-md">
                                @if ($user->email_verified_at)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                    <span class="ml-2 text-sm">
                                        {{ $user->email_verified_at->format('M j, Y g:i A') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Not Verified
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- 2FA -->
                        <div>
                            <x-label for="two_factor_confirmed_at" value="{{ __('2FA') }}" />
                            <div class="mt-1 block w-full px-3 py-2  border border-gray-300 rounded-md">
                                @if ($user->two_factor_confirmed_at)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Activated
                                    </span>
                                    <span class="ml-2 text-sm">
                                        {{ $user->two_factor_confirmed_at->format('M j, Y g:i A') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Not Activated
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Created At -->
                        <div>
                            <x-label for="created_at" value="{{ __('Account Created') }}" />
                            <div class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                                {{ $user->created_at->format('M j, Y g:i A') }}
                            </div>
                        </div>

                        <!-- Updated At -->
                        <div>
                            <x-label for="updated_at" value="{{ __('Last Updated') }}" />
                            <div class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                                {{ $user->updated_at->format('M j, Y g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
