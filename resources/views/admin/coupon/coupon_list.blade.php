@extends('admin.layouts.app')
@section('title','Coupon List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Coupon List</h4>

                <div class="page-title-right">
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-sm btn-primary">
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
                            <form method="GET" action="{{ route('admin.coupons.index') }}">
                                <div class="row">
                                    <div class="col-md-4 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="coupon_code" class="form-control"
                                                   placeholder="Search by Coupon Code" value="{{ request('coupon_code') ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <select name="valid_for" class="form-select">
                                                <option value="" {{ !isset(request()->valid_for) ? 'selected' : '' }}>
                                                    Valid For
                                                </option>
                                                @foreach (getValidForUser() as $user)
                                                    <option value="{{ $user->value }}"
                                                        {{ request('valid_for') === $user->value ? 'selected' : '' }}>
                                                        {{ $user->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <select name="discount_type" class="form-select">
                                                <option value="" {{ !isset(request()->discount_type) ? 'selected' : '' }}>
                                                    Discount Type
                                                </option>
                                                @foreach (discountTypes() as $type)
                                                    <option value="{{ $type->value }}"
                                                        {{ request('discount_type') === $type->value ? 'selected' : '' }}>
                                                        {{ $type->title }}</option>
                                                @endforeach
                                            </select>
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
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead class="table-light">
                            <tr>
                                <th class="text-center">Sl.no</th>
                                <th>Valid For</th>
                                <th>Discount Type</th>
                                <th>Discount</th>
                                <th>Limit</th>
                                <th>Min. Cost</th>
                                <th>Up-to</th>
                                <th class="text-center">Date Range</th>
                                <th class="text-center">Active Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody class="sort_section">
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>{{ str_replace('-', ' ', ucwords($coupon->valid_for, '-')) ?? '' }}</td>
                                    <td>{{ ucFirst($coupon->discount_type) ?? '' }}</td>
                                    <td>{{ $coupon->discount ?? '' }} {{ $coupon->discount_type === 'percentage' ? '%' : '' }}</td>
                                    <td>{{ $coupon->used_limit ?? '' }}</td>
                                    <td>{{ $coupon->minimum_cost ?? '' }}</td>
                                    <td>{{ $coupon->up_to ?? '' }}</td>
                                    <td class="text-center">
                                        {{ dateFormat($coupon->start_date,'d M, y') .' to '. dateFormat($coupon->end_date,'d M, y') }}
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" id="coupon-{{ $loop->index + 1 }}" class="coupon-status" data-id="{{ $coupon->id }}" switch="bool" {{ isActive($coupon->status) ? 'checked' : '' }} />
                                        <label class="custom-label-margin" for="coupon-{{ $loop->index + 1 }}" data-on-label="Yes" data-off-label="No"></label>
                                    </td>
                                    <td class="text-center">
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.coupons.edit', encrypt_decrypt($coupon->id, 'encrypt')) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i>
                                        </a>
                                         <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                           class="btn btn-sm btn-soft-danger delete-data"
                                           data-id="{{ 'delete-coupon-'.$coupon->id }}"
                                           href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-coupon-{{ $coupon->id }}"
                                              action="{{ route('admin.coupons.destroy',$coupon->id) }}"
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
                    {!! $coupons->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
     <script src="{{ asset('assets/admin/js/custom/coupon_lists.js') }}"></script>
@endpush
