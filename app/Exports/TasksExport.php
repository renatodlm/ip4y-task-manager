<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class TasksExport implements FromCollection
{
    protected $tasks;

    public function __construct(Collection $tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Export the filtered tasks.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->tasks;
    }
}
