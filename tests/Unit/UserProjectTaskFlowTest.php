<?php

use App\Services\TaskService;
use App\Services\ProjectService;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\TaskRepositoryInterface;
use Mockery;

beforeEach(function ()
{
    $this->userRepositoryMock    = Mockery::mock(UserRepositoryInterface::class);
    $this->projectRepositoryMock = Mockery::mock(ProjectRepositoryInterface::class);
    $this->taskRepositoryMock    = Mockery::mock(TaskRepositoryInterface::class);

    $this->projectService = new ProjectService($this->projectRepositoryMock);
    $this->taskService    = new TaskService(
        $this->taskRepositoryMock,
        $this->projectRepositoryMock,
        $this->userRepositoryMock
    );
});

it('creates a user', function ()
{
    $userData = ['id' => 1, 'name' => 'John Doe'];

    $this->userRepositoryMock
        ->shouldReceive('create')
        ->once()
        ->with($userData)
        ->andReturn((object) $userData);

    $user = $this->userRepositoryMock->create($userData);

    expect($user)->toBeObject();
    expect($user->name)->toBe('John Doe');
});

it('creates a project', function ()
{
    $projectData = ['id' => 1, 'name' => 'Project 1'];

    $this->projectRepositoryMock
        ->shouldReceive('create')
        ->once()
        ->with($projectData)
        ->andReturn((object) $projectData);

    $project = $this->projectRepositoryMock->create($projectData);

    expect($project)->toBeObject();
    expect($project->name)->toBe('Project 1');
});

it('creates a task for a project', function ()
{
    $taskData = ['id' => 1, 'title' => 'Task 1', 'project_id' => 1];

    $this->taskRepositoryMock
        ->shouldReceive('create')
        ->once()
        ->with($taskData)
        ->andReturn((object) $taskData);

    $task = $this->taskRepositoryMock->create($taskData);

    expect($task)->toBeObject();
    expect($task->title)->toBe('Task 1');
    expect($task->project_id)->toBe(1);
});

afterEach(function ()
{
    Mockery::close();
});
