<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Interfaces\ProjectServiceInterface;
use App\Models\Project;

class ProjectController extends Controller
{
    protected $ProjectService;

    /**
     * ProjectController constructor.
     *
     * @param ProjectServiceInterface $ProjectService
     */
    public function __construct(ProjectServiceInterface $ProjectService)
    {
        $this->ProjectService = $ProjectService;
    }

    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = $this->ProjectService->get_all_projects();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     *
     * @param ProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectRequest $request)
    {
        $this->ProjectService->create_project($request->validated());
        return redirect()->route('projects.index')->with('success', 'Project successfully created!');
    }

    /**
     * Display the specified project.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $project = $this->ProjectService->get_project_by_id($id);

        if (!$project)
        {
            return redirect()->route('projects.index')->with('error', 'Project not found.');
        }

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $project = $this->ProjectService->get_project_by_id($id);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param ProjectRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectRequest $request, $id)
    {
        $this->ProjectService->update_project($id, $request->validated());
        return redirect()->route('projects.index')->with('success', 'Project successfully updated!');
    }

    /**
     * Remove the specified project from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->ProjectService->delete_project($id);
        return redirect()->route('projects.index')->with('success', 'Project successfully deleted!');
    }

    /**
     * Total tasks count
     */
    public function count_projects()
    {
        return Project::count();
    }
}
