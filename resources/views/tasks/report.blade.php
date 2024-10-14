<h1>Report Tasks</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Project</th>
            <th>Assigned To</th>
            <th>Status</th>
            <th>Due Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>{{ $task->project->title }}</td>
            <td>{{ $task->user->name }}</td>
            <td>{{ $statusLabels[$task->status] ?? $task->status }}</td>
            <td>{{ \Carbon\Carbon::parse($task->due_date)->format('m/d/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
