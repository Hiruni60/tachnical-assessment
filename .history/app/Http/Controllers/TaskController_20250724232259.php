<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::where('is_completed', false)
            ->latest()
            ->take(5)
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        return Task::create($validated);
    }

    public function complete(Task $task)
    {
        $task->update(['is_completed' => true]);

        return response()->json(['message' => 'Task completed']);
    }
}
