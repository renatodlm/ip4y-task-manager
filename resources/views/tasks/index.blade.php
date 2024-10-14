@php
$statusLabels = [
'pending' => 'Pending',
'in_progress' => 'In Progress',
'completed' => 'Completed',
];
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>

        <div class="flex gap-4 mt-2 lg:items-end flex-wrap">
            <a href="{{ route('tasks.create') }}" class="inline-flex h-fit items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                Create New Task
            </a>

            <form method="GET" class="flex gap-4 lg:items-center ml-auto flex-wrap">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
                    <select name="status" id="status" class="form-select mt-1 block w-full">
                        <option value="">{{ __('All') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="in_progress">{{ __('In Progress') }}</option>
                        <option value="completed">{{ __('Completed') }}</option>
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Start Date') }}</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date', \Carbon\Carbon::now()->subDays(30)->toDateString()) }}" class="form-input mt-1 block w-full">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('End Date') }}</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date', \Carbon\Carbon::now()->toDateString()) }}" class="form-input mt-1 block w-full">
                </div>

                <div class="flex gap-2 mt-6">
                    <button type="submit" class="bg-indigo-600 text-white h-fit py-2 px-4 rounded">{{ __('Filter') }}</button>
                    @if(!$tasks->isEmpty())
                    <a href="{{ route('tasks.report.pdf', request()->query()) }}" class="inline-flex items-center h-fit px-4 py-2 bg-red-600 text-white rounded-md">Export to PDF</a>
                    <a href="{{ route('tasks.report.excel', request()->query()) }}" class="inline-flex items-center h-fit px-4 py-2 bg-green-600 text-white rounded-md">Export to Excel</a>
                    @endif;
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($tasks->isEmpty())
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700 dark:text-gray-300">No tasks found.</p>
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Project</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assigned To</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Due date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($tasks as $task)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">
                                {{ $task->title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                {{ $task->project->title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                {{ $task->user->name }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">
                                {{ $statusLabels[$task->status] ?? $task->status }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($task->due_date)->format('m/d/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <a href="{{ route('tasks.show', $task->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-500 dark:hover:text-indigo-400">View</a>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="ml-4 text-yellow-600 hover:text-yellow-900 dark:text-yellow-500 dark:hover:text-yellow-400">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-400">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
