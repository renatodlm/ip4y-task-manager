<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->get_all_tasks();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create', [
            'projects' => $this->taskService->get_all_projects(),
            'users'    => $this->taskService->get_all_users(),
        ]);
    }

    public function store(TaskRequest $request)
    {
        $this->taskService->create_task($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function show($id)
    {
        $task = $this->taskService->get_task_by_ID($id);

        if (!$task)
        {
            return redirect()->route('tasks.index')->with('error', 'Task not found.');
        }

        return view('tasks.show', compact('task'));
    }

    public function edit($id)
    {
        $task = $this->taskService->get_task_by_ID($id);
        return view('tasks.edit', [
            'task'     => $task,
            'projects' => $this->taskService->get_all_projects(),
            'users'    => $this->taskService->get_all_users(),
        ]);
    }

    public function update(TaskRequest $request, $id)
    {
        $this->taskService->update_task($id, $request->validated());
        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $this->taskService->delete_task($id);
        return redirect()->route('tasks.index')->with('success', 'Tarefa deletada com sucesso!');
    }
}
