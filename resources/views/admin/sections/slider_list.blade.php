@extends('admin.layouts.app')
@section('title','Slider List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Slider List</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-sm btn-primary">
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
                            <form method="GET" action="{{ route('admin.sliders.index') }}">
                                <div class="row">
                                    <div class="col-md-6 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="search" class="form-control"
                                                   placeholder="Search by Title/Caption"
                                                   value="{{ request('search') ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="status" class="form-control">
                                                <option value="" {{ !isset(request()->status) ? 'selected' : '' }}>
                                                    Status
                                                </option>
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
                    <x-sort-available/>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                            <tr>
                                <th>Sl.no</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Highlighted Title</th>
                                <th>Caption</th>
                                <th>Highlighted Caption</th>
                                <th>Redirect Link</th>
                                <th>Product Count</th>
                                <th>Active Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="sort_section">
                            @forelse($sliders as $slider)
                                <tr data-id="{{ $slider->id }}">
                                    <td class="handle sorting-serial">{{ $slider->sorting_serial }}</td>
                                    <td class="handle">
                                        @if($slider->image_path != Null && file_exists($slider->image_path))
                                            <img src="{{ asset($slider->image_path) }}"
                                                 class="avatar-sm rounded-3 d-block img-50">
                                        @else
                                            <img src="{{ asset(ecommerceIcon()) }}"
                                                 class="avatar-sm rounded-3 d-block img-50">
                                        @endif
                                    </td>
                                    <td class="handle">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                              title="{{ $slider->title ?? '' }}">
                                            {{ textLimit($slider->title) ?? '' }}
                                        </span>
                                    </td>
                                    <td class="handle">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                              title="{{ $slider->highlighted_title ?? '' }}">
                                            {{ textLimit($slider->highlighted_title) ?? '' }}
                                        </span>
                                    </td>
                                    <td class="handle">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                              title="{{ $slider->caption ?? '' }}">
                                            {{ textLimit($slider->caption) ?? '' }}
                                        </span>
                                    </td>
                                    <td class="handle">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                              title="{{ $slider->highlighted_caption ?? '' }}">
                                            {{ textLimit($slider->highlighted_caption) ?? '' }}
                                        </span>
                                    </td>
                                    <td class="handle">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                              title="{{ $slider->redirect_link ?? '' }}">
                                            {{ textLimit($slider->redirect_link) ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $slider?->products?->count() ?? 0 }}
                                        <a href="{{ route('admin.slider-products',$slider->id) }}">Products</a>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="slider-{{ $loop->index + 1 }}" class="slider-status"
                                               data-id="{{ $slider->id }}"
                                               switch="bool" {{ isActive($slider->status) ? 'checked' : '' }} />
                                        <label for="slider-{{ $loop->index + 1 }}" data-on-label="Yes"
                                               data-off-label="No"></label>
                                    </td>
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.sliders.edit',$slider->id) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                           class="btn btn-sm btn-soft-danger delete-data"
                                           data-id="{{ 'delete-slider-'.$slider->id }}"
                                           href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-slider-{{ $slider->id }}"
                                              action="{{ route('admin.sliders.destroy',$slider->id) }}"
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
                    {!! $sliders->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/slider_lists.js') }}"></script>
@endpush
