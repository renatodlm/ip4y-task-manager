<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;

class TasksExport implements FromCollection
{
    /**
     * Export all tasks.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Task::all();
    }
}
