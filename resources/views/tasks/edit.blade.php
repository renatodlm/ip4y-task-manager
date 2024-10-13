<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" id="title" name="title" value="{{ $task->title }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300">{{ $task->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project</label>
                <select id="project_id" name="project_id" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300">
                    @foreach ($projects as $project)
                    <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <select id="status" name="status" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300" required>
                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                <input type="date" id="due_date" name="due_date" value="{{ $task->due_date }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300">
            </div>

            <div class="mb-6">
                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assign to</label>
                <select id="user_id" name="user_id" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $task->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    Update Task
                </button>
                <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white dark:bg-gray-500 hover:bg-gray-700 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
