@extends('admin.layouts.app')
@section('title','Manage Product Type')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Manage Product Type</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-sort-available />
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                            <tr>
                                <th>Sl.no</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Image</th>
                                <th>Bound Categories</th>
                            </tr>
                            </thead>
                            <tbody class="sort_section">
                            @forelse($product_types as $type)
                                <tr data-id="{{ $type->id }}">
                                    <td class="handle sorting-serial">{{ $type->sorting_serial }}</td>
                                    <td class="handle">{{ $type->name ?? '' }}</td>
                                    <td class="handle">
                                        @if($type->icon != Null && file_exists($type->icon))
                                            <img src="{{ asset($type->icon) }}" class="avatar-sm rounded-3 d-block img-50">
                                        @else
                                            <img src="{{ asset(ecommerceIcon()) }}" class="avatar-sm rounded-3 d-block img-50">
                                        @endif
                                    </td>
                                    <td class="handle">
                                        @if($type->image != Null && file_exists($type->image))
                                            <img src="{{ asset($type->image) }}" class="avatar-sm rounded-3 d-block img-50">
                                        @else
                                            <img src="{{ asset(ecommerceIcon()) }}" class="avatar-sm rounded-3 d-block img-50">
                                        @endif
                                    </td>
                                    <td>
                                        {{ $type->category_names ?? '' }}
                                        @if(count($type->product_category_ids))
                                            <a href="{{ route('admin.product-types-category-bound',$type->slug) }}"><i class="fa fa-plus-circle"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <x-no-data-found></x-no-data-found>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/product_type_lists.js') }}"></script>
@endpush
