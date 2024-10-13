<?php

namespace App\Interfaces;

interface TaskServiceInterface
{
    public function create_task(array $data);
    public function update_task(int $id, array $data);
    public function delete_task(int $id);
    public function get_task_by_ID(int $id);
    public function get_all_tasks();
    public function get_all_projects();
    public function get_all_users();
}
