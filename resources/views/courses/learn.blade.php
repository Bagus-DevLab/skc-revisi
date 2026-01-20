<x-app-layout>
    <div class="min-h-screen bg-gray-50">
    {{-- Success Alert --}}
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 pt-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    {{-- Header Course --}}
    <div class="bg-white border-b sticky top-0 z-10"></div>
        {{-- Header Course --}}
        <div class="bg-white border-b sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    {{-- Back Button & Course Title --}}
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard') }}" 
                           class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">{{ $course->title }}</h1>
                            <p class="text-sm text-gray-500">{{ $course->category }}</p>
                        </div>
                    </div>

                    {{-- Progress --}}
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">Progress:</span>
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" 
                                 style="width: {{ $enrollment->pivot->progress }}%"></div>
                        </div>
                        <span class="text-sm font-semibold text-blue-600">
                            {{ $enrollment->pivot->progress }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Video Player Area --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Video Container --}}
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="aspect-video bg-black">
                            <iframe 
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/SqcY0GlETPk"
                                title="Course Video" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                        
                        {{-- Video Info --}}
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                                Perkenalan {{ $course->title }}
                            </h2>
                            <p class="text-gray-600 mb-4">
                                Video 1 dari 10 • Durasi: 15 menit
                            </p>
                            
                            {{-- Action Buttons --}}
                            <div class="flex gap-3">
                                <form action="{{ route('course.complete-lesson', $course->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                        ✓ Tandai Selesai & Lanjut
                                    </button>
                                </form>
                                <button class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    📝 Catatan
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Course Description --}}
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold mb-3">Tentang Kursus Ini</h3>
                        <div class="prose prose-sm max-w-none text-gray-600">
                            {{ $course->description }}
                        </div>
                    </div>
                </div>
                {{-- Tab Navigation --}}
                <div class="bg-white rounded-lg shadow">
                    {{-- Tab Headers --}}
                    <div class="border-b">
                        <nav class="flex -mb-px">
                            <button 
                                onclick="switchTab('overview')"
                                id="tab-overview"
                                class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-blue-600 text-blue-600">
                                📚 Ringkasan
                            </button>
                            <button 
                                onclick="switchTab('notes')"
                                id="tab-notes"
                                class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                📝 Catatan Saya
                            </button>
                            <button 
                                onclick="switchTab('quiz')"
                                id="tab-quiz"
                                class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                ✅ Mini Quiz
                            </button>
                            <button 
                                onclick="switchTab('discussion')"
                                id="tab-discussion"
                                class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                💬 Diskusi
                            </button>
                        </nav>
                    </div>

                    {{-- Tab Contents --}}
                    <div class="p-6">
                        {{-- Overview Tab --}}
                        <div id="content-overview" class="tab-content">
                            <h3 class="text-lg font-bold mb-3">Tentang Video Ini</h3>
                            <div class="prose prose-sm max-w-none text-gray-600">
                                <p class="mb-4">{{ $course->description }}</p>
                                
                                <h4 class="font-semibold text-gray-900 mt-6 mb-2">Yang Akan Dipelajari:</h4>
                                <ul class="space-y-2">
                                    <li>✓ Memahami konsep dasar {{ $course->category }}</li>
                                    <li>✓ Menguasai tools dan framework terkini</li>
                                    <li>✓ Praktik langsung dengan studi kasus nyata</li>
                                    <li>✓ Tips dan trik dari praktisi berpengalaman</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Notes Tab --}}
                        <div id="content-notes" class="tab-content hidden">
                            <h3 class="text-lg font-bold mb-4">Catatan Pribadi</h3>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <p class="text-sm text-yellow-800">
                                    💡 <strong>Tips:</strong> Tulis catatan penting saat menonton video untuk memudahkan review nanti!
                                </p>
                            </div>
                            
                            <textarea 
                                class="w-full border border-gray-300 rounded-lg p-4 min-h-[200px] focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Tulis catatan Anda di sini...&#10;&#10;Contoh:&#10;- 05:30 - Konsep penting tentang...&#10;- 12:15 - Perlu dipraktikkan lagi..."></textarea>
                            
                            <div class="mt-4 flex gap-3">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                                    💾 Simpan Catatan
                                </button>
                                <button class="border border-gray-300 hover:bg-gray-50 px-6 py-2 rounded-lg transition">
                                    📋 Lihat Semua Catatan
                                </button>
                            </div>
                        </div>

                        {{-- Quiz Tab --}}
                        <div id="content-quiz" class="tab-content hidden">
                            <h3 class="text-lg font-bold mb-4">Mini Quiz - Uji Pemahaman Anda</h3>
                            
                            <div class="space-y-6">
                                {{-- Question 1 --}}
                                <div class="border border-gray-200 rounded-lg p-5">
                                    <p class="font-semibold text-gray-900 mb-3">
                                        1. Apa hal terpenting yang dipelajari di video ini?
                                    </p>
                                    <div class="space-y-2">
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="radio" name="q1" class="mr-3">
                                            <span class="text-sm">Konsep dasar dan penerapannya</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="radio" name="q1" class="mr-3">
                                            <span class="text-sm">Tools yang digunakan</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="radio" name="q1" class="mr-3">
                                            <span class="text-sm">Best practices dalam industri</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- Question 2 --}}
                                <div class="border border-gray-200 rounded-lg p-5">
                                    <p class="font-semibold text-gray-900 mb-3">
                                        2. Bagaimana cara menerapkan materi ini dalam project nyata?
                                    </p>
                                    <textarea 
                                        class="w-full border border-gray-300 rounded-lg p-3 min-h-[100px] text-sm"
                                        placeholder="Tulis jawaban Anda..."></textarea>
                                </div>
                            </div>

                            <button class="mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                ✓ Submit Quiz
                            </button>
                        </div>

                        {{-- Discussion Tab --}}
                        <div id="content-discussion" class="tab-content hidden">
                            <h3 class="text-lg font-bold mb-4">Diskusi & Tanya Jawab</h3>
                            
                            {{-- Comment Form --}}
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                                <textarea 
                                    class="w-full border border-gray-300 rounded-lg p-3 min-h-[100px] mb-3 bg-white"
                                    placeholder="Punya pertanyaan atau ingin berbagi insight?"></textarea>
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                                    💬 Kirim Komentar
                                </button>
                            </div>

                            {{-- Sample Comments --}}
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                            A
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-sm">Ahmad Rizky</p>
                                            <p class="text-xs text-gray-500 mb-2">2 hari yang lalu</p>
                                            <p class="text-sm text-gray-700">
                                                Penjelasannya sangat jelas! Langsung bisa praktik dan berhasil. Terima kasih! 🙏
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                            S
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-sm">Siti Nurhaliza</p>
                                            <p class="text-xs text-gray-500 mb-2">5 hari yang lalu</p>
                                            <p class="text-sm text-gray-700">
                                                Ada rekomendasi resource tambahan untuk memperdalam materi ini?
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Playlist --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow">
                        {{-- Header --}}
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-bold text-gray-900">Daftar Materi</h3>
                            <p class="text-sm text-gray-500 mt-1">10 Video • {{ $course->duration }} jam</p>
                        </div>

                        {{-- Playlist Items --}}
                        <div class="divide-y max-h-[600px] overflow-y-auto">
                            @php
                                $lessons = [
                                    ['title' => 'Perkenalan ' . $course->category, 'duration' => '15:30', 'completed' => true],
                                    ['title' => 'Konsep Dasar', 'duration' => '22:45', 'completed' => true],
                                    ['title' => 'Tools dan Setup', 'duration' => '18:20', 'completed' => false],
                                    ['title' => 'Praktik Pertama', 'duration' => '25:10', 'completed' => false],
                                    ['title' => 'Tips dan Trik', 'duration' => '20:15', 'completed' => false],
                                    ['title' => 'Studi Kasus 1', 'duration' => '30:40', 'completed' => false],
                                    ['title' => 'Studi Kasus 2', 'duration' => '28:55', 'completed' => false],
                                    ['title' => 'Best Practices', 'duration' => '24:30', 'completed' => false],
                                    ['title' => 'Troubleshooting', 'duration' => '19:45', 'completed' => false],
                                    ['title' => 'Penutup & Sertifikat', 'duration' => '12:20', 'completed' => false],
                                ];
                            @endphp

                            @foreach($lessons as $index => $lesson)
                            <div class="p-4 hover:bg-gray-50 cursor-pointer transition {{ $index === 0 ? 'bg-blue-50 border-l-4 border-blue-600' : '' }}">
                                <div class="flex items-start gap-3">
                                    {{-- Status Icon --}}
                                    <div class="flex-shrink-0 mt-1">
                                        @if($lesson['completed'])
                                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        @elseif($index === 0)
                                            <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Lesson Info --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 {{ $index === 0 ? 'text-blue-600' : '' }}">
                                            {{ $index + 1 }}. {{ $lesson['title'] }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <span>{{ $lesson['duration'] }}</span>
                                            @if($lesson['completed'])
                                                <span class="ml-2 text-green-600">• Selesai</span>
                                            @elseif($index === 0)
                                                <span class="ml-2 text-blue-600">• Sedang diputar</span>
                                            @endif
                                        </p>
                                    </div>

                                    {{-- Lock Icon for locked lessons --}}
                                    @if(!$lesson['completed'] && $index > 2)
                                    <div class="flex-shrink-0">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-blue-600', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Add active state to clicked button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.add('active', 'border-blue-600', 'text-blue-600');
            activeButton.classList.remove('border-transparent', 'text-gray-500');
        }
    </script>
    @endpush
</x-app-layout>