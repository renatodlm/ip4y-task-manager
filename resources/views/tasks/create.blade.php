<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('tasks.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project</label>
                    <select name="project_id" id="project_id" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300" required>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300" required>
                        <option value="pending">Pendente</option>
                        <option value="in_progress">Em progresso</option>
                        <option value="completed">Concluída</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300">
                </div>

                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assign To</label>
                    <select name="user_id" id="user_id" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300" required>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    Create
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
