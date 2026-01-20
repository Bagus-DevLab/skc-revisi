<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-label for="title" value="{{ __('Title') }}" />
                                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$course->title" required autofocus autocomplete="title" />
                            </div>
                            <div>
                                <x-label for="category" value="{{ __('Category') }}" />
                                <x-input id="category" class="block mt-1 w-full" type="text" name="category" :value="$course->category" required />
                            </div>
                            <div>
                                <x-label for="price" value="{{ __('Price') }}" />
                                <x-input id="price" class="block mt-1 w-full" type="number" name="price" :value="$course->price" required />
                            </div>
                            <div>
                                <x-label for="duration" value="{{ __('Duration') }}" />
                                <x-input id="duration" class="block mt-1 w-full" type="number" name="duration" :value="$course->duration" required />
                            </div>
                            <div>
                                <x-label for="description" value="{{ __('Description') }}" />
                                <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ $course->description }}</textarea>
                            </div>
                            <div>
                                <x-label for="image" value="{{ __('Image') }}" />
                                <x-input id="image" class="block mt-1 w-full" type="file" name="image" />
                                @if ($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="mt-2 w-32 h-32 object-cover">
                                @endif
                            </div>
                            <div>
                                <x-label for="rating" value="{{ __('Rating') }}" />
                                <x-input id="rating" class="block mt-1 w-full" type="number" name="rating" :value="$course->rating" required />
                            </div>
                            <div>
                                <x-label for="students_count" value="{{ __('Students Count') }}" />
                                <x-input id="students_count" class="block mt-1 w-full" type="number" name="students_count" :value="$course->students_count" required />
                            </div>
                            <div>
                                <x-label for="difficulty_level" value="{{ __('Difficulty Level') }}" />
                                <x-input id="difficulty_level" class="block mt-1 w-full" type="number" name="difficulty_level" :value="$course->difficulty_level" required />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-4">
                                    {{ __('Update') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
