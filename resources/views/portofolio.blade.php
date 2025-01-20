<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['pt3'] ?? 'Portofolio' }} - {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}</title>
    <meta name="description" content="{{ $settings['company_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['company_keywords'] ?? '' }}">
    <script src="https://kit.fontawesome.com/050b5dcfea.js" crossorigin="anonymous"></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('layouts.header')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-head to-blue-900 text-white py-24 mt-20">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-black/30"></div>
            @if(isset($settings['ic3']) && $settings['ic3'])
                <img src="{{ asset('storage/' . $settings['ic3']) }}" 
                     alt="bg portofolio {{ $settings['company_name'] ?? '' }}" 
                     class="w-full h-full object-cover object-center">
            @else
                <img src="{{ asset('asset/image3.jpg') }}" 
                     alt="bg portofolio default" 
                     class="w-full h-full object-cover object-center">
            @endif
        </div>
        <div class="relative container mx-auto px-4 text-center z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Portofolio {{ $settings['company_name'] }}</h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-2xl mx-auto">{{ $settings['company_tagline'] }}</p>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Proyek Terbaru Kami</h2>
                <div class="w-20 h-1 bg-yellow-400 mx-auto mb-6"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    {{ $settings['company_description'] }}
                </p>
            </div>
            
            <!-- Portfolio Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($portfolios as $item)
                <div class="group bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
                    <div class="relative overflow-hidden">
                        @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" 
                             alt="{{ $item->title }}" 
                             class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        @else
                        <img src="https://via.placeholder.com/600x400" 
                             alt="{{ $item->title }}" 
                             class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 bg-yellow-400 text-black text-sm font-medium rounded-full">
                                        {{ $item->category }}
                                    </span>
                                    <span class="px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-full">
                                        {{ $item->year }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $item->title }}
                        </h3>
                        <p class="text-gray-600 mb-4">{{ $item->description }}</p>
                       <!-- Dalam loop portfolio, update link detail -->
@if($item->link)
<a href="{{ route('portfolio.show', $item->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
    Lihat Detail
    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
</a>
@endif
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">Belum ada portfolio yang ditambahkan</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>

    @include('layouts.footer')
</body>
</html>
