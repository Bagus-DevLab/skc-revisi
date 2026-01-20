<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-label for="title" value="{{ __('Title') }}" />
                                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" />
                            </div>
                            <div>
                                <x-label for="category" value="{{ __('Category') }}" />
                                <x-input id="category" class="block mt-1 w-full" type="text" name="category" :value="old('category')" required />
                            </div>
                            <div>
                                <x-label for="price" value="{{ __('Price') }}" />
                                <x-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required />
                            </div>
                            <div>
                                <x-label for="duration" value="{{ __('Duration') }}" />
                                <x-input id="duration" class="block mt-1 w-full" type="number" name="duration" :value="old('duration')" required />
                            </div>
                            <div>
                                <x-label for="description" value="{{ __('Description') }}" />
                                <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            </div>
                            <div>
                                <x-label for="image" value="{{ __('Image') }}" />
                                <x-input id="image" class="block mt-1 w-full" type="file" name="image" />
                            </div>
                            <div>
                                <x-label for="rating" value="{{ __('Rating') }}" />
                                <x-input id="rating" class="block mt-1 w-full" type="number" name="rating" :value="old('rating')" required />
                            </div>
                            <div>
                                <x-label for="students_count" value="{{ __('Students Count') }}" />
                                <x-input id="students_count" class="block mt-1 w-full" type="number" name="students_count" :value="old('students_count')" required />
                            </div>
                            <div>
                                <x-label for="difficulty_level" value="{{ __('Difficulty Level') }}" />
                                <x-input id="difficulty_level" class="block mt-1 w-full" type="number" name="difficulty_level" :value="old('difficulty_level')" required />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-4">
                                    {{ __('Create') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
