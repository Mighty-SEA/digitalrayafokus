<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $portfolio->title }} - {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}</title>
    <meta name="description" content="{{ $portfolio->description }}">
    @if(isset($settings['company_favicon']) && $settings['company_favicon'])
        <link rel="icon" href="{{ asset('storage/' . $settings['company_favicon']) }}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('layouts.header')

    <!-- Hero Section with Parallax Effect -->
    <section class="relative bg-gradient-to-b from-head to-blue-900 text-white py-32 mt-20 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-black/40"></div>
            <img src="{{ Storage::url($portfolio->image) }}" 
                 alt="{{ $portfolio->title }}" 
                 class="w-full h-full object-cover object-center transform scale-110 motion-safe:animate-subtle-zoom">
        </div>
        <div class="relative container mx-auto px-4 text-center z-10">
            <div class="animate-fade-up">
                <div class="flex items-center justify-center space-x-3 mb-6">
                    <span class="px-4 py-2 bg-yellow-400 text-black text-sm font-medium rounded-full shadow-lg">
                        {{ $portfolio->category }}
                    </span>
                    <span class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-full shadow-lg">
                        {{ $portfolio->year }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6 text-shadow-lg">{{ $portfolio->title }}</h1>
                <p class="text-lg md:text-xl text-gray-200 max-w-2xl mx-auto">
                    {{ Str::limit($portfolio->description, 120) }}
                </p>
            </div>
        </div>
    </section>

    <!-- Portfolio Detail -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Description Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-12 transform hover:shadow-2xl transition-all duration-300">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                        Deskripsi Proyek
                    </h2>
                    <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed mb-8">
                        {{ $portfolio->description }}
                    </div>

                    <!-- Additional Images with Gallery Effect -->
                    @if($portfolio->image2 || $portfolio->image3)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                        @if($portfolio->image2)
                        <div class="rounded-xl overflow-hidden shadow-lg group">
                            <div class="relative">
                                <img src="{{ Storage::url($portfolio->image2) }}" 
                                     alt="{{ $portfolio->title }} - Detail 1" 
                                     class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="absolute bottom-4 left-4">
                                        <span class="text-white text-sm font-medium">Detail View 1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($portfolio->image3)
                        <div class="rounded-xl overflow-hidden shadow-lg group">
                            <div class="relative">
                                <img src="{{ Storage::url($portfolio->image3) }}" 
                                     alt="{{ $portfolio->title }} - Detail 2" 
                                     class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="absolute bottom-4 left-4">
                                        <span class="text-white text-sm font-medium">Detail View 2</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($portfolio->link)
                    <div class="mt-12">
                        <a href="{{ $portfolio->link }}" 
                           target="_blank"
                           class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-globe mr-2"></i>
                            Kunjungi Website
                            <i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Related Projects -->
                @if($relatedPortfolios->count() > 0)
                <div class="mt-20">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Proyek Terkait</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedPortfolios as $related)
                        <a href="{{ route('portfolio.show', $related->id) }}" 
                           class="group bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                            <div class="relative overflow-hidden">
                                <img src="{{ Storage::url($related->image) }}" 
                                     alt="{{ $related->title }}" 
                                     class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="absolute bottom-4 left-4">
                                        <span class="text-white text-sm font-medium">{{ $related->category }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $related->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2">{{ $related->year }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Back Button -->
                <div class="mt-12 text-center">
                    <a href="{{ route('portofolio') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-700 transition-colors duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Portfolio
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <style>
        .text-shadow-lg {
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        @keyframes subtle-zoom {
            from { transform: scale(1.1); }
            to { transform: scale(1.15); }
        }
        .animate-subtle-zoom {
            animation: subtle-zoom 20s ease-in-out infinite alternate;
        }
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up {
            animation: fade-up 1s ease-out forwards;
        }
    </style>
</body>
</html> 