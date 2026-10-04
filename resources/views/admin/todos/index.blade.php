@extends('admin.layouts.app')
@section('title', 'To-Do List')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <style>
        .fc-event {
            cursor: pointer;
            font-size: 11px;
        }

        .todo-event-done {
            opacity: 0.5;
            text-decoration: line-through;
        }

        .priority-badge {
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 700;
        }

        .priority-high {
            background: #fde8ea;
            color: #e63946;
        }

        .priority-medium {
            background: #fff4e6;
            color: #f4a261;
        }

        .priority-low {
            background: #e8faf8;
            color: #2ec4b6;
        }

        .todo-card {
            border-left: 4px solid var(--color-primary);
        }

        .todo-card.done {
            border-left-color: #9ca3af;
            opacity: .7;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4><i class="bx bx-task"></i> To-Do List</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTodoModal">
                    <i class="bx bx-plus"></i> Add Todo
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Calendar Widget --}}
        <div class="col-xl-5 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title"><i class="bx bx-calendar"></i> Calendar View</h5>
                </div>
                <div class="card-body">
                    <div id="todo-calendar"></div>
                </div>
            </div>
        </div>

        {{-- Todo List --}}
        <div class="col-xl-7 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title"><i class="bx bx-list-check"></i> Tasks</h5>
                    <div class="d-flex gap-2">
                        @foreach (['all' => 'All', 'pending' => 'Pending', 'in_progress' => 'In Progress', 'done' => 'Done'] as $val => $label)
                            <a href="{{ route('admin.todos.index', ['status' => $val]) }}"
                                class="btn btn-sm {{ $status === $val ? 'btn-primary' : 'btn-soft-primary' }}">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="card-body" style="max-height: 520px; overflow-y: auto;">
                    @forelse($todos as $todo)
                        <div class="card mb-2 todo-card {{ $todo->status === 'done' ? 'done' : '' }}"
                            id="todo-{{ $todo->id }}">
                            <div class="card-body py-2 px-3">
                                <div class="d-flex align-items-center gap-3">
                                    <input type="checkbox" {{ $todo->status === 'done' ? 'checked' : '' }}
                                        class="todo-check" data-id="{{ $todo->id }}"
                                        style="width:18px;height:18px;accent-color:var(--color-primary);cursor:pointer;">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="fw-600"
                                                style="{{ $todo->status === 'done' ? 'text-decoration:line-through;color:#9ca3af;' : '' }}">{{ $todo->title }}</span>
                                            <span
                                                class="priority-badge priority-{{ $todo->priority }}">{{ ucfirst($todo->priority) }}</span>
                                            @if ($todo->due_date)
                                                <small class="text-muted"><i class="bx bx-calendar-alt"></i>
                                                    {{ $todo->due_date->format('M d') }}</small>
                                            @endif
                                        </div>
                                        @if ($todo->description)
                                            <small class="text-muted">{{ Str::limit($todo->description, 80) }}</small>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-soft-info py-1 px-2 edit-todo-btn"
                                            data-todo="{{ json_encode($todo) }}" data-bs-toggle="modal"
                                            data-bs-target="#editTodoModal">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.todos.destroy', $todo) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger py-1 px-2"
                                                onclick="return confirm('Delete this todo?')" {!! tooltip('Delete') !!}>
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bx bx-check-circle" style="font-size:3rem;"></i>
                            <p class="mt-2">No todos found. Add one above!</p>
                        </div>
                    @endforelse
                    {{ $todos->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Add Todo Modal --}}
    <div class="modal fade" id="addTodoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-plus-circle me-2"></i>Add New Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.todos.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="Todo title...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Details..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="pending" selected>Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Todo Modal --}}
    <div class="modal fade" id="editTodoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-edit me-2"></i>Edit Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editTodoForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="editDescription" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Priority</label>
                                <select name="priority" id="editPriority" class="form-select">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" id="editStatus" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" id="editDueDate" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        // Calendar
        document.addEventListener('DOMContentLoaded', function() {
            var calEl = document.getElementById('todo-calendar');
            var calendar = new FullCalendar.Calendar(calEl, {
                initialView: 'dayGridMonth',
                height: 420,
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                events: {!! $calendarData->toJson() !!},
                eventClick: function(info) {
                    alert(info.event.title);
                }
            });
            calendar.render();
        });

        // Edit modal prefill
        document.querySelectorAll('.edit-todo-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var todo = JSON.parse(btn.dataset.todo);
                document.getElementById('editTitle').value = todo.title;
                document.getElementById('editDescription').value = todo.description || '';
                document.getElementById('editPriority').value = todo.priority;
                document.getElementById('editStatus').value = todo.status;
                document.getElementById('editDueDate').value = todo.due_date ? todo.due_date.substring(0,
                    10) : '';
                document.getElementById('editTodoForm').action = '/admin/todos/' + todo.id;
            });
        });

        // AJAX checkbox toggle
        document.querySelectorAll('.todo-check').forEach(function(cb) {
            cb.addEventListener('change', function() {
                var id = cb.dataset.id;
                var $card = document.getElementById('todo-' + id);
                $.ajax({
                    url: '/admin/todos/' + id + '/toggle-status',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.status === 'done') {
                            $card.classList.add('done');
                            $card.querySelector('span.fw-600').style.textDecoration =
                                'line-through';
                        } else {
                            $card.classList.remove('done');
                            $card.querySelector('span.fw-600').style.textDecoration = '';
                        }
                    }
                });
            });
        });
    </script>
@endpush
