<h1>Relatório de Projetos</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Data de Entrega</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>{{ $task->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
