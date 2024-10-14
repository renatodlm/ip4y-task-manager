<?php

namespace App\Interfaces;

interface ProjectServiceInterface
{
    public function create_project(array $data);
    public function update_project(int $id, array $data);
    public function delete_project(int $id);
    public function get_project_by_id(int $id);
    public function get_all_projects();
}
