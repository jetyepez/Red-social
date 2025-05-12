<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="relative">
                    <!-- Cover Photo -->
                    <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                    
                    <!-- Profile Photo -->
                    <div class="absolute -bottom-16 left-8">
                        <div class="h-32 w-32 rounded-full border-4 border-white bg-white overflow-hidden">
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-full w-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="pt-20 pb-6 px-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                            <p class="text-gray-600">@{{ auth()->user()->username }}</p>
                        </div>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Edit Profile
                        </button>
                    </div>

                    <!-- Bio -->
                    <p class="mt-4 text-gray-700">
                        {{ auth()->user()->bio ?? 'No bio yet' }}
                    </p>

                    <!-- Stats -->
                    <div class="flex gap-8 mt-6">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-900">0</span>
                            <span class="text-gray-600">Posts</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-900">0</span>
                            <span class="text-gray-600">Followers</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-900">0</span>
                            <span class="text-gray-600">Following</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Settings -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                        @livewire('profile.update-profile-information-form')
                        <x-section-border />
                    @endif

                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.update-password-form')
                        </div>
                        <x-section-border />
                    @endif

                    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.two-factor-authentication-form')
                        </div>
                        <x-section-border />
                    @endif

                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.logout-other-browser-sessions-form')
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                        <x-section-border />
                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.delete-user-form')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
