<?php

namespace App\Services;

use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\ProjectServiceInterface;

class ProjectService implements ProjectServiceInterface
{
    protected $project_repository;

    /**
     * ProjectService constructor.
     *
     * @param ProjectRepositoryInterface $project_repository
     */
    public function __construct(ProjectRepositoryInterface $project_repository)
    {
        $this->project_repository = $project_repository;
    }

    /**
     * Create a new project.
     *
     * @param array $data
     * @return mixed
     */
    public function create_project(array $data)
    {
        return $this->project_repository->create($data);
    }

    /**
     * Update an existing project by ID.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update_project(int $id, array $data)
    {
        return $this->project_repository->update($id, $data);
    }

    /**
     * Delete a project by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete_project(int $id)
    {
        return $this->project_repository->delete($id);
    }

    /**
     * Get a project by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function get_project_by_id(int $id)
    {
        return $this->project_repository->find($id);
    }

    /**
     * Get all projects.
     *
     * @return mixed
     */
    public function get_all_projects()
    {
        return $this->project_repository->all();
    }
}
