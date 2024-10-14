<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;

class TaskController extends Controller
{
    protected $task_service;

    /**
     * Initialize the TaskController with the TaskServiceInterface.
     *
     * @param TaskServiceInterface $task_service
     */
    public function __construct(TaskServiceInterface $task_service)
    {
        $this->task_service = $task_service;
    }

    /**
     * Display a listing of tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = $this->task_service->get_all_tasks();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tasks.create', [
            'projects' => $this->task_service->get_all_projects(),
            'users'    => $this->task_service->get_all_users(),
        ]);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskRequest $request)
    {
        $this->task_service->create_task($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Display the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $task = $this->task_service->get_task_by_id((int) $id);

        if (!$task)
        {
            return redirect()->route('tasks.index')->with('error', 'Tarefa não encontrada.');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $task = $this->task_service->get_task_by_id($id);
        return view('tasks.edit', [
            'task'     => $task,
            'projects' => $this->task_service->get_all_projects(),
            'users'    => $this->task_service->get_all_users(),
        ]);
    }

    /**
     * Update the specified task in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskRequest $request, $id)
    {
        $this->task_service->update_task($id, $request->validated());
        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->task_service->delete_task($id);
        return redirect()->route('tasks.index')->with('success', 'Tarefa deletada com sucesso!');
    }

    /**
     * Download the project report as PDF.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download_pdf()
    {
        return $this->task_service->generate_task_report_pdf();
    }

    /**
     * Download the project report as Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download_excel()
    {
        return $this->task_service->generate_task_report_excel();
    }
}
