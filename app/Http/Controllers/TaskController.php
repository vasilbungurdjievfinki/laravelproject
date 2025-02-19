<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create($request->all());

        return response()->json($task, 201);
    }

    public function index(Request $request)
    {
        $tasks = Task::query();

        if ($request->has('category_id')) {
            $tasks->where('category_id', $request->input('category_id'));
        }

        if ($request->has('status')) {
            $tasks->where('status', $request->input('status'));
        }

        $tasks = $tasks->get();
        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function markAsCompleted($id)
    {
        $task = Task::findOrFail($id);
        $task->status = 'completed';
        $task->save();

        return redirect()->route('tasks.index');
    }
}
