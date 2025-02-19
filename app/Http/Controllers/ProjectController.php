<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function filterByDueDate(Request $request)
    {
        $dueDate = $request->input('due_date');
        $projects = Project::where('due_date', '<=', $dueDate)->get();
        return view('projects.index', compact('projects'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $project = Project::create($request->all());

        return response()->json($project, 201);
    }

}
