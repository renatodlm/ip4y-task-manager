<?php

namespace App\Interfaces;

interface ProjectServiceInterface
{
    public function create_project(array $data);
    public function update_project(int $id, array $data);
    public function delete_project(int $id);
    public function get_project_by_ID(int $id);
    public function get_all_projects();
    public function generate_project_report_pdf();
    public function generate_project_report_excel();
}
