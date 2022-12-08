@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Categories')
@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Categories & Subcategories
                </h2>
            </div>
        </div>
    </div>

    @livewire('categories')

@endsection
@push('scripts')
    <script>
        window.addEventListener('hideCategoriesModal', function(e) {
            $('#categories_modal').modal('hide');
        });
        window.addEventListener('showcategoriesModal', function(e) {
            $('#categories_modal').modal('show');
        });

        window.addEventListener('hideSubCategoriesModal', function(e) {
            $('#subcategories_modal').modal('hide');
        });

        window.addEventListener('showSubCategoriesModal', function(e) {
            $('#subcategories_modal').modal('show');
        });

        $('#categories_modal,#subcategories_modal').on('hidden.bs.modal', function(e) {
            Livewire.emit('resetModalForm');
        });
        Livewire.on('deleteCategory', function(e) {
            swal.fire({
                title: e.title,
                html: e.html,
                imageWidth: 48,
                imageHeight: 48,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                width: 300,
                allowOutsideClick: false
            }).then((res) => {
                if (res.value) {
                    window.livewire.emit('deleteCategoryAct', e.id)
                }
            })
        })
        Livewire.on('deleteSubCategory', function(e) {
            swal.fire({
                title: e.title,
                html: e.html,
                imageWidth: 48,
                imageHeight: 48,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                width: 300,
                allowOutsideClick: false
            }).then((res) => {
                if (res.value) {
                    window.livewire.emit('deleteSubCategoryAct', e.id)
                }
            })
        })
    </script>
@endpush
