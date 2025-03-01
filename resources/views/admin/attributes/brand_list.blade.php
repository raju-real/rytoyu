@extends('admin.layouts.app')
@section('title','Brand List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Brand List</h4>

                <div class="page-title-right">
                    <a href="{{ route('admin.brands.create') }}" class="btn btn-sm btn-primary">
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
                            <form method="GET" action="{{ route('admin.brands.index') }}">
                                <div class="row">
                                    <div class="col-md-6 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="name" class="form-control"
                                                   placeholder="Search by Name" value="{{ request('name') ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="status" class="form-select">
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
                    <div class="table-responsive">
                        <x-sort-available />
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                            <tr>
                                <th>Sl.no</th>
                                <th>Name</th>
                                <th>Logo</th>
                                <th>Image</th>
                                <th>Product Count</th>
                                <th>Active Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="sort_section">
                            @forelse($brands as $brand)
                                <tr data-id="{{ $brand->id }}">
                                    <td class="handle sorting-serial">{{ $loop->index + 1 }}</td>
                                    <td class="handle">{{ $brand->name ?? '' }}</td>
                                    <td class="handle">
                                        @if($brand->logo != Null && file_exists($brand->logo))
                                            <img src="{{ asset($brand->logo) }}" class="avatar-sm rounded-3 d-block img-50">
                                        @else
                                            <img src="{{ asset(ecommerceIcon()) }}" class="avatar-sm rounded-3 d-block img-50">
                                        @endif
                                    </td>
                                    <td class="handle">
                                        @if($brand->image != Null && file_exists($brand->image))
                                            <img src="{{ asset($brand->image) }}" class="avatar-sm rounded-3 d-block img-50">
                                        @else
                                            <img src="{{ asset(ecommerceIcon()) }}" class="avatar-sm rounded-3 d-block img-50">
                                        @endif
                                    </td>
                                    <td class="handle">{{ $brand?->products?->count() ?? 0 }}</td>
                                    <td>
                                        <input type="checkbox" id="brand-{{ $loop->index + 1 }}" class="brand-status" data-id="{{ $brand->id }}" switch="bool" {{ isActive($brand->status) ? 'checked' : '' }} />
                                        <label for="brand-{{ $loop->index + 1 }}" data-on-label="Yes" data-off-label="No"></label>
                                    </td>
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.brands.edit',$brand->slug) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i>
                                        </a>
                                         <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                           class="btn btn-sm btn-soft-danger delete-data"
                                           data-id="{{ 'delete-brand-'.$brand->id }}"
                                           href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-brand-{{ $brand->id }}"
                                              action="{{ route('admin.brands.destroy',$brand->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <x-no-data-found></x-no-data-found>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="d-flex justify-content-center">
                    {!! $brands->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
     <script src="{{ asset('assets/admin/js/custom/brand_lists.js') }}"></script>
@endpush
