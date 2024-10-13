<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    protected $task;

    /**
     * TaskRepository constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data)
    {
        return $this->task->create($data);
    }

    /**
     * Update the specified task by ID.
     *
     * @param int $id
     * @param array $data
     * @return Task|null
     */
    public function update(int $id, array $data)
    {
        $task = $this->find($id);
        if ($task)
        {
            $task->update($data);
            return $task;
        }

        return null;
    }

    /**
     * Delete the specified task by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $task = $this->find($id);

        if ($task)
        {
            $task->delete();
            return true;
        }

        return false;
    }

    /**
     * Find a task by ID.
     *
     * @param int $id
     * @return Task|null
     */
    public function find(int $id)
    {
        return $this->task->find($id);
    }

    /**
     * Get all tasks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Task[]
     */
    public function all()
    {
        return $this->task->all();
    }
}
