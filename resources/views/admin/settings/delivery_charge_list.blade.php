@extends('admin.layouts.app')
@section('title','Delivery Charge List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Delivery Charge List</h4>

                <div class="page-title-right">
                    <a href="{{ route('admin.delivery-charges.create') }}" class="btn btn-sm btn-primary">
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
                            <form method="GET" action="{{ route('admin.delivery-charges.index') }}">
                                <div class="row">
                                    <div class="col-md-6 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="district_name" class="form-control"
                                                   placeholder="Search by District Name" value="{{ request('district_name') ?? '' }}">
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
                            <thead>
                            <tr>
                                <th class="text-center">Sl.no</th>
                                <th>District Name</th>
                                <th>Delivery Charge</th>
                                <th class="text-center">Active Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody class="sort_section">
                            @forelse($delivery_charges as $charge)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>{{ $charge->district_name ?? '' }}</td>
                                    <td>{{ $charge->delivery_charge ?? 0.00 }}</td>
                                    <td class="text-center">
                                        <input type="checkbox" id="charge-{{ $loop->index + 1 }}" class="charge-status" data-id="{{ $charge->id }}" switch="bool" {{ isActive($charge->status) ? 'checked' : '' }} />
                                        <label for="charge-{{ $loop->index + 1 }}" data-on-label="Yes" data-off-label="No"></label>
                                    </td>
                                    <td class="text-center">
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.delivery-charges.edit',$charge->slug) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i>
                                        </a>
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
                    {!! $delivery_charges->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
     <script src="{{ asset('assets/admin/js/custom/delivery_charge_lists.js') }}"></script>
@endpush
