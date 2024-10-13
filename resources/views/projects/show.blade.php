<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $project->description }}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-6">{{ \Carbon\Carbon::parse($project->due_date)->format('M d, Y') }}</p>

                <div class="flex space-x-4">
                    <a href="{{ route('projects.edit', $project->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white dark:bg-yellow-600 hover:bg-yellow-600 dark:hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                        Edit
                    </a>

                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white dark:bg-red-500 hover:bg-red-700 dark:hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
