@extends('admin.layouts.app')
@section('title','Section List')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Section List</h4>

                <div class="page-title-right">
                    <a href="{{ route('admin.add-section') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus-circle"></i> Add New
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="alert alert-info">You can change sorting serial by drag and drop form here.</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                            <tr>
                                <th>Sl.no</th>
                                <th>Section Title</th>
                                <th>Module</th>
                                <th>Section For</th>
                                <th>Items</th>
                                <th>Active Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="sort_section">
                            @forelse($sections as $section)
                                <tr data-id="{{ $section->id }}">
                                    <td class="handle sorting-serial">{{ $section->sorting_serial }}</td>
                                    <td class="handle">{{ $section->section_title ?? '' }}</td>
                                    <td class="handle">{{ $section->section_module ?? '' }}</td>
                                    <td class="handle">{{ ucfirst($section->section_for) ?? 'Unknown' }}</td>
                                    <td>
                                        @if($section->section_module === 'product')
                                            <a href="">Products</a>
                                        @elseif($section->)
                                    </td>
                                    <td>
                                        <input type="checkbox" id="section-{{ $loop->index + 1 }}"
                                               class="section-status" data-id="{{ $section->id }}"
                                               switch="bool" {{ isActive($section->status) ? 'checked' : '' }} />
                                        <label for="section-{{ $loop->index + 1 }}" data-on-label="Yes"
                                               data-off-label="No"></label>
                                    </td>
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.edit-section',$section->section_slug) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>
                                        @if($section->section_module === 'custom')
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                               class="btn btn-sm btn-soft-danger delete-data"
                                               data-id="{{ 'delete-section-'.$section->id }}"
                                               href="javascript:void(0);">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <form id="delete-section-{{ $section->id }}"
                                                  action="{{ route('admin.delete-section',$section->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
    <script src="{{ asset('assets/admin/js/custom/section_list.js') }}"></script>
@endpush
