<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ProjectService;
use App\Interfaces\ProjectRepositoryInterface;
use Mockery;

class ProjectServiceTest extends TestCase
{
   protected $projectService;
   protected $projectRepositoryMock;

   protected function setUp(): void
   {
      parent::setUp();

      $this->projectRepositoryMock = Mockery::mock(ProjectRepositoryInterface::class);
      $this->projectService = new ProjectService($this->projectRepositoryMock);
   }

   public function testget_all_projects()
   {
      $projects = collect([['id' => 1, 'name' => 'Project 1'], ['id' => 2, 'name' => 'Project 2']]);

      $this->projectRepositoryMock
         ->shouldReceive('all')
         ->once()
         ->andReturn($projects);

      $result = $this->projectService->get_all_projects();

      $this->assertEquals($projects, $result);
   }

   protected function tearDown(): void
   {
      Mockery::close();
      parent::tearDown();
   }
}
