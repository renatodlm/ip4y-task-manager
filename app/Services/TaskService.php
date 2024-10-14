<?php

namespace App\Services;

use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\TaskServiceInterface;
use App\Models\User;
use App\Notifications\TaskAssigned;
use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TasksExport;

class TaskService implements TaskServiceInterface
{
    protected $task_repository;
    protected $project_repository;
    protected $user_repository;

    /**
     * TaskService constructor.
     *
     * @param TaskRepositoryInterface $task_repository
     * @param ProjectRepositoryInterface $project_repository
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        ProjectRepositoryInterface $projectRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->task_repository    = $taskRepository;
        $this->project_repository = $projectRepository;
        $this->user_repository    = $userRepository;
    }

    /**
     * Create a new task and notify the assigned user.
     *
     * @param array $data
     * @return mixed
     */
    public function create_task(array $data)
    {
        $task = $this->task_repository->create($data);
        $user = User::find($data['user_id']);

        $user->notify(new TaskAssigned($task));

        return $task;
    }

    /**
     * Update an existing task by ID.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update_task(int $id, array $data)
    {
        return $this->task_repository->update($id, $data);
    }

    /**
     * Delete a task by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete_task(int $id)
    {
        return $this->task_repository->delete($id);
    }

    /**
     * Get a task by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function get_task_by_id(int $id)
    {
        return $this->task_repository->find($id);
    }

    /**
     * Get all tasks.
     *
     * @return mixed
     */
    public function get_all_tasks()
    {
        return $this->task_repository->all();
    }

    /**
     * Get all projects.
     *
     * @return mixed
     */
    public function get_all_projects()
    {
        return $this->task_repository->all();
    }

    /**
     * Get all users.
     *
     * @return mixed
     */
    public function get_all_users()
    {
        return $this->user_repository->all();
    }

    /**
     * Generate a PDF report of all tasks.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate_task_report_pdf()
    {
        $tasks = $this->task_repository->all();
        $pdf   = Pdf::loadView('tasks.report', compact('tasks'));

        return $pdf->download('task_report.pdf');
    }

    /**
     * Generate an Excel report of all tasks.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generate_task_report_excel()
    {
        return Excel::download(new TasksExport, 'task_report.xlsx');
    }
}
