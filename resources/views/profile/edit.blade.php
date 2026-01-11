<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Profile') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Compte') }}</p>
        </div>
    </x-slot>

    <div class="row gx-3 gx-lg-4">
        <div class="col-12 col-lg-8">
            <div class="card adminuiux-card mb-3 mb-lg-4">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card adminuiux-card mb-3 mb-lg-4">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card adminuiux-card mb-3 mb-lg-4">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
