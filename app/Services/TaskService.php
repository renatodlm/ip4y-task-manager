<?php

namespace App\Services;

use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\TaskServiceInterface;
use App\Models\User;
use App\Notifications\TaskAssigned;
use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class TaskService implements TaskServiceInterface
{
    protected $taskRepository;
    protected $projectRepository;
    protected $userRepository;

    /**
     * TaskService constructor.
     *
     * @param TaskRepositoryInterface $taskRepository
     * @param ProjectRepositoryInterface $projectRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        ProjectRepositoryInterface $projectRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->taskRepository    = $taskRepository;
        $this->projectRepository = $projectRepository;
        $this->userRepository    = $userRepository;
    }

    /**
     * Create a new task and notify the assigned user.
     *
     * @param array $data
     * @return mixed
     */
    public function create_task(array $data)
    {
        $task = $this->taskRepository->create($data);
        $user = User::find($data['user_id']);

        $user->notify(new TaskAssigned($task));

        return $task;
    }

    /**
     * Update a task by ID.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update_task(int $id, array $data)
    {
        return $this->taskRepository->update($id, $data);
    }

    /**
     * Delete a task by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete_task(int $id)
    {
        return $this->taskRepository->delete($id);
    }

    /**
     * Get a task by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function get_task_by_id(int $id)
    {
        return $this->taskRepository->find($id);
    }

    /**
     * Get all tasks.
     *
     * @return mixed
     */
    public function get_all_tasks()
    {
        return $this->taskRepository->all();
    }

    /**
     * Get all projects.
     *
     * @return mixed
     */
    public function get_all_projects()
    {
        return $this->projectRepository->all();
    }

    /**
     * Get all users.
     *
     * @return mixed
     */
    public function get_all_users()
    {
        return $this->userRepository->all();
    }
}
