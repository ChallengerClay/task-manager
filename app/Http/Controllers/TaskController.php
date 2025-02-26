<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $tasks = Task::get();
        $categories = Category::all();
        return view('task.index', compact('tasks','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create(['task' => $validated['task']]);
        if($task){
            $task->categories()->attach($validated['categories']);

            $newrow = '<tr id="task-'.$task->id.'" class=" text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <td class="px-6 py-4">
                        '.$task->id.'
                    </td>
                    <td class="px-6 py-4">
                        '.$task->task.'
                    </td>
                    <td>';
            foreach ($task->categories as $category){
                $newrow .= '<span class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">'.$category->name.'</span>';
            }
            $newrow .='</td>
                    <td class="px-6 py-4 text-center">
                        <a data-id="'.$task->id.'" class="delete" id="delete" href="#"><span class="text-base text-red-500">X</span></a>
                    </td>
                </tr>';
            return response()->json(['newrow' => $newrow, 'message'=> __("task stored")]);
        }else{
            return response()->json(['message' => $request->errors()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        
        $task->categories()->detach();

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
