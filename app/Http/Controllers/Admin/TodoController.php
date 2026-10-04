<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $adminId  = authAdmin()->id;
        $status   = $request->get('status', 'all');
        $query    = Todo::where('admin_id', $adminId)->latest('due_date');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $todos        = $query->paginate(20);
        $calendarData = Todo::where('admin_id', $adminId)
            ->whereNotNull('due_date')
            ->get(['id', 'title', 'due_date', 'status', 'priority'])
            ->map(fn($t) => [
                'id'    => $t->id,
                'title' => $t->title,
                'start' => $t->due_date->toDateString(),
                'color' => match ($t->priority) {
                    'high'   => '#e63946',
                    'medium' => '#f4a261',
                    default  => '#2ec4b6',
                },
                'className' => $t->status === 'done' ? 'todo-event-done' : 'todo-event-pending',
            ]);

        return view('admin.todos.index', compact('todos', 'status', 'calendarData'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'status'      => 'required|in:pending,in_progress,done',
            'due_date'    => 'nullable|date',
        ]);

        $data['admin_id'] = authAdmin()->id;
        Todo::create($data);

        return back()->with('success', 'Todo added successfully.');
    }

    public function update(Request $request, Todo $todo)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'status'   => 'required|in:pending,in_progress,done',
            'due_date' => 'nullable|date',
        ]);

        $todo->update($data);
        return back()->with('success', 'Todo updated.');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return back()->with('success', 'Todo deleted.');
    }

    /** AJAX: Toggle status */
    public function toggleStatus(Request $request, Todo $todo)
    {
        $todo->update(['status' => $todo->status === 'done' ? 'pending' : 'done']);
        return response()->json(['status' => $todo->status, 'success' => true]);
    }
}
