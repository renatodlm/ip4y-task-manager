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
        @foreach($projects as $project)
            <tr>
                <td>{{ $project->id }}</td>
                <td>{{ $project->title }}</td>
                <td>{{ $project->due_date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
