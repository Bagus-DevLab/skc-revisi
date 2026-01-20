<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kursus Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Statistik Ringkas (Real Data) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium">Total Kursus</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalCourses }} Kursus</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm font-medium">Sedang Dipelajari</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $ongoingCount }} Kursus</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium">Selesai</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $finishedCount }} Kursus</div>
                </div>
            </div>

            {{-- Grid Daftar Kursus (Real Data) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($enrollments as $course)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition {{ $course->pivot->status === 'finished' ? 'opacity-90' : '' }}">
                        
                        {{-- Thumbnail --}}
                        <div class="h-40 bg-gray-200 relative {{ $course->pivot->status === 'finished' ? 'grayscale' : '' }}">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500 text-xs">No Image</div>
                            @endif

                            @if($course->pivot->status === 'finished')
                                <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                                    Selesai
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    {{ $course->category }}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $course->description }}</p>
                            
                            <div class="mt-auto">
                                <div class="flex justify-between text-xs text-gray-600 mb-1">
                                    <span>Progress</span>
                                    <span class="font-bold {{ $course->pivot->progress == 100 ? 'text-green-600' : '' }}">
                                        {{ $course->pivot->progress }}%
                                    </span>
                                </div>
                                
                                {{-- Progress Bar --}}
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                    <div class="{{ $course->pivot->status === 'finished' ? 'bg-green-500' : 'bg-blue-600' }} h-2.5 rounded-full" 
                                         style="width: {{ $course->pivot->progress }}%"></div>
                                </div>

                                {{-- Action Buttons --}}
                                @if($course->pivot->status === 'finished')
                                    <div class="flex gap-2">
                                        <button class="flex-1 bg-gray-100 text-gray-700 text-sm font-bold py-2 px-4 rounded-lg hover:bg-gray-200 transition">
                                            Review
                                        </button>
                                        <a href="{{ route('my-certificates') }}" class="flex-1 bg-green-600 text-white text-sm font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition flex justify-center items-center gap-1 text-center">
                                            Sertifikat
                                        </a>
                                    </div>
                                @else
                                    <button class="w-full bg-blue-600 text-white text-sm font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                        Lanjutkan Belajar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Tampilan jika belum daftar kursus apapun --}}
                    <div class="col-span-full bg-white rounded-xl p-12 text-center border-2 border-dashed">
                        <p class="text-gray-500 mb-4 font-medium italic">Anda belum memiliki kursus yang diikuti.</p>
                        <a href="/" class="text-blue-600 font-bold hover:underline">Cari Kursus Sekarang &rarr;</a>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>