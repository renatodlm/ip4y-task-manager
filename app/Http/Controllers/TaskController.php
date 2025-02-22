<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Exports\TasksExport;

/**
 * @OA\PathItem(
 *     path="/api/tasks"
 * )
 */
class TaskController extends Controller
{
    protected $TaskService;

    /**
     * Initialize the TaskController with the TaskServiceInterface.
     *
     * @param TaskServiceInterface $TaskService
     */
    public function __construct(TaskServiceInterface $TaskService)
    {
        $this->TaskService = $TaskService;
    }

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Obter todas as tarefas",
     *     description="Retorna todas as tarefas registradas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tarefas retornada com sucesso"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('status') && !empty($request->status))
        {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date') && !empty($request->start_date))
        {
            $query->whereDate('due_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date))
        {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        $tasks = $query->get();

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
            'projects' => $this->TaskService->get_all_projects(),
            'users'    => $this->TaskService->get_all_users(),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Criar uma nova tarefa",
     *     description="Cria uma nova tarefa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", example="Nova Tarefa"),
     *             @OA\Property(property="description", type="string", example="Descrição da tarefa"),
     *             @OA\Property(property="project_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tarefa criada com sucesso"
     *     )
     * )
     */
    public function store(TaskRequest $request)
    {
        $this->TaskService->create_task($request->validated());
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
        $task = $this->TaskService->get_task_by_id((int) $id);

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
        $task = $this->TaskService->get_task_by_id($id);

        return view('tasks.edit', [
            'task'     => $task,
            'projects' => $this->TaskService->get_all_projects(),
            'users'    => $this->TaskService->get_all_users(),
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
        $this->TaskService->update_task($id, $request->validated());
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
        $this->TaskService->delete_task($id);

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
