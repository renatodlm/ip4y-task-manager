<?php

namespace App\Repositories;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    protected $project;

    /**
     * ProjectRepository constructor.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Create a new project.
     *
     * @param array $data
     * @return Project
     */
    public function create(array $data)
    {
        return $this->project->create($data);
    }

    /**
     * Update the specified project by ID.
     *
     * @param int $id
     * @param array $data
     * @return Project|null
     */
    public function update(int $id, array $data)
    {
        $project = $this->find($id);

        if ($project)
        {
            $project->update($data);
            return $project;
        }

        return null;
    }

    /**
     * Delete the specified project by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $project = $this->find($id);

        if ($project)
        {
            $project->delete();
            return true;
        }

        return false;
    }

    /**
     * Find a project by ID.
     *
     * @param int $id
     * @return Project|null
     */
    public function find(int $id)
    {
        return $this->project->find($id);
    }

    /**
     * Get all projects.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Project[]
     */
    public function all()
    {
        return $this->project->all();
    }
}
