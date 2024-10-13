<?php

namespace App\Services;

use App\Exports\ProjectsExport;
use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\ProjectServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ProjectService implements ProjectServiceInterface
{
    protected $projectRepository;

    /**
     * ProjectService constructor.
     *
     * @param ProjectRepositoryInterface $projectRepository
     */
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Create a new project.
     *
     * @param array $data
     * @return mixed
     */
    public function create_project(array $data)
    {
        return $this->projectRepository->create($data);
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
        return $this->projectRepository->update($id, $data);
    }

    /**
     * Delete a project by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete_project(int $id)
    {
        return $this->projectRepository->delete($id);
    }

    /**
     * Get a project by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function get_project_by_ID(int $id)
    {
        return $this->projectRepository->find($id);
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
     * Generate a PDF report of all projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate_project_report_pdf()
    {
        $projects = $this->projectRepository->all();
        $pdf      = Pdf::loadView('projects.report', compact('projects'));

        return $pdf->download('project_report.pdf');
    }

    /**
     * Generate an Excel report of all projects.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generate_project_report_excel()
    {
        return Excel::download(new ProjectsExport, 'project_report.xlsx');
    }
}
