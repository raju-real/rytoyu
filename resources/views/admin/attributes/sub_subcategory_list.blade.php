@extends('admin.layouts.app')
@section('title','Sub Subcategory List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sub Subcategory List</h4>

                <div class="page-title-right">
                    <a href="{{ route('admin.sub-subcategories.create') }}" class="btn btn-sm btn-primary">
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
                            <form method="GET" action="{{ route('admin.sub-subcategories.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="category" class="form-select" id="category">
                                                <option value="" {{ !isset(request()->category) ? 'selected' : '' }}>
                                                    Category
                                                </option>
                                                @foreach(activeCategories() as $category)
                                                    <option
                                                        value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pb-4">
                                        <div class="from-group">
                                            <select name="subcategory" id="subcategory" class="form-select"
                                                    data-old-value="{{ subCategoryIdBySlug(request('subcategory'))  }}">
                                                <option value="">Sub Category</option>
                                                    @if(!empty(request('subcategory')))
                                                    <option value="{{ request('subcategory') }}"
                                                            selected>{{ subcategoryNameBySlug(request('subcategory')) }}</option>
                                                        @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pb-4">
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
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Icon</th>
                                <th>Product Count</th>
                                <th>Active Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="sort_section">
                            @forelse($sub_subcategories as $sub_subcategory)
                                <tr data-id="{{ $sub_subcategory->id }}" data-category-id="{{ $sub_subcategory->category_id }}" data-subcategory-id="{{ $sub_subcategory->subcategory_id }}">
                                    <td class="handle sorting-serial">{{ $sub_subcategory->sorting_serial }}</td>
                                    <td class="handle">{{ $sub_subcategory->name ?? '' }}</td>
                                    <td class="handle">{{ $sub_subcategory?->category?->name ?? '' }}</td>
                                    <td class="handle">{{ $sub_subcategory?->subcategory?->name ?? '' }}</td>
                                    <td class="handle">
                                        @if($sub_subcategory->icon != Null && file_exists($sub_subcategory->icon))
                                            <img src="{{ asset($sub_subcategory->icon) }}"
                                                 class="avatar-sm rounded-3 d-block img-50">
                                        @else
                                            <img src="{{ asset(ecommerceIcon()) }}"
                                                 class="avatar-sm rounded-3 d-block img-50">
                                        @endif
                                    </td>
                                    <td class="handle">{{ $sub_subcategory?->products?->count() ?? 0 }}</td>
                                    <td>
                                        <input type="checkbox" id="sub-subcategory-{{ $loop->index + 1 }}" class="sub-subcategory-status" data-id="{{ $sub_subcategory->id }}" switch="bool" {{ isActive($sub_subcategory->status) ? 'checked' : '' }} />
                                        <label for="sub-subcategory-{{ $loop->index + 1 }}" data-on-label="Yes" data-off-label="No"></label>
                                    </td>
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.sub-subcategories.edit',$sub_subcategory->slug) }}"
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
                <div class="d-flex justify-content-center">
                    {!! $sub_subcategories->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/sub_sub_category.js') }}"></script>
@endpush
