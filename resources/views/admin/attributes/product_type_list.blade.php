@extends('admin.layouts.app')
@section('title','Product Type List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Product Type List</h4>

                <div class="page-title-right">
                    <a href="{{ route('admin.product-types.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus-circle"></i> Add New
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Accordion for Search -->
            <div class="accordion mb-3" id="accordionSearch">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSearch">
                        <button class="accordion-button {{ request()->query() ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseSearch"
                                aria-expanded="{{ request()->query() ? 'true' : 'false' }}"
                                aria-controls="collapseSearch">
                            Search
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                         aria-labelledby="headingSearch"
                         data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form method="GET" action="{{ route('admin.product-types.index') }}">
                                <div class="row">
                                    <div class="col-md-6 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="name" class="form-control"
                                                   placeholder="Search by Name" value="{{ request('name') ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="status" class="form-control">
                                                <option value="" {{ !isset(request()->status) ? 'selected' : '' }}>Status</option>
                                                @foreach(getStatus() as $status)
                                                    <option
                                                        value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>{{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-0">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                <th>Product Count</th>
                                <th>Active Status</th>
                                <th>Action</th>
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
                                    <td class="handle">{{ $type?->products?->count() ?? 0 }}</td>
                                    <td>
                                        <input type="checkbox" id="category-{{ $loop->index + 1 }}" class="category-status" data-id="{{ $type->id }}" switch="bool" {{ isActive($type->status) ? 'checked' : '' }} />
                                        <label for="category-{{ $loop->index + 1 }}" data-on-label="Yes" data-off-label="No"></label>
                                    </td>
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.product-types.edit',$type->slug) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>
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
