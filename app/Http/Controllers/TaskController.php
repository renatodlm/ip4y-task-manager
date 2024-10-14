<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Exports\TasksExport;

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
    public function index(Request $request)
    {
        $query = Task::query();

        // Filtro por status
        if ($request->has('status') && !empty($request->status))
        {
            $query->where('status', $request->status);
        }

        // Filtro por data de início
        if ($request->has('start_date') && !empty($request->start_date))
        {
            $query->whereDate('due_date', '>=', $request->start_date);
        }

        // Filtro por data de fim
        if ($request->has('end_date') && !empty($request->end_date))
        {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        // Executar a query e obter as tasks
        $tasks = $query->get();

        // Retornar a view com as tasks filtradas
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
     * Download the task report as PDF.
     */
    public function download_pdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $query = Task::query();

        if ($request->has('status') && !empty($request->status))
        {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date'))
        {
            $query->whereDate('due_date', '>=', $request->start_date);
        }

        if ($request->has('end_date'))
        {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        $tasks = $query->get();

        $pdf = Pdf::loadView('tasks.report', compact('tasks'));

        return $pdf->download('task_report.pdf');
    }

    /**
     * Download the task report as Excel.
     */
    public function download_excel(Request $request)
    {
        $request->validate([
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $query = Task::query();

        if ($request->has('status') && !empty($request->status))
        {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date'))
        {
            $query->whereDate('due_date', '>=', $request->start_date);
        }

        if ($request->has('end_date'))
        {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        $tasks = $query->get();

        return Excel::download(new TasksExport($tasks), 'task_report.xlsx');
    }

    /**
     * Total tasks count
     */
    public function count_tasks()
    {
        return Task::count();
    }
}
