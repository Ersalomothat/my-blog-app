@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Profile')
@section('content')
    @livewire('author-profile-header')
    <hr>
    <div class="row">
        <div class="card">
            <ul class="nav nav-tabs" data-bs-toggle="tabs">
                <li class="nav-item">
                    <a href="#tabs-details" class="nav-link active" data-bs-toggle="tab">Personal Details</a>
                </li>
                <li class="nav-item">
                    <a href="#tabs-password" class="nav-link" data-bs-toggle="tab">Change Password</a>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabs-details">
                        <div>
                            @livewire('author-personal-details')
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-password">
                        @livewire('author-change-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- baris 38 pages-layout --}}
{{-- https://github.com/Mbere250/ijaboCropTool --}}
@push('scripts')
    <script>
        $("#changeAuthorPictureFile").ijaboCropTool({
            preview: '',
            setRatio: 1,
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            buttonsText: ['CROP', 'QUIT'],
            buttonsColor: ['#30bf7d', '#ee5155', -15],
            processUrl: "{{ route('author/change.profile.picture') }}",
            withCSRF: ['_token', '{{ csrf_token() }}'],
            onSuccess: function(message, element, status) {
                Livewire.emit('UpdateAuthorProfileHeader');
                Livewire.emit('UpdateTopHeader');
                toastr.success(message)
            },
            onError: function(message, element, status) {
                toastr.error(message)
            }
        });
    </script>
@endpush
