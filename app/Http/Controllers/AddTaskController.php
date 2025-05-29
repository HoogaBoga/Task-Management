<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AddTaskController;
use Illuminate\Http\Request;

class AddTaskController extends Controller
{
    public function create()
    {
        return view('add-task');
    }


    public function store(Request $request)
    {
        return redirect()->back()->with('success', 'Task created successfully!');
    }
}
