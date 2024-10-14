<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ __("You're logged in!") }}
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Projects</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $project_count }}</p>
                        <a href="{{ route('projects.index') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">View Projects</a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Tasks</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $task_count }}</p>
                        <a href="{{ route('tasks.index') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">View Tasks</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
