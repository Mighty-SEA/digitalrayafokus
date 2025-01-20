<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service['title'] }} - {{ $settings['company_name'] }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $service['description'] }}">
    <meta name="keywords" content="{{ $service['title'] }}, {{ strtolower($service['title']) }}, layanan {{ strtolower($service['title']) }}, {{ $settings['company_name'] }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $service['title'] }} - {{ $settings['company_name'] }}">
    <meta property="og:description" content="{{ $service['description'] }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    <!-- Schema.org Markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Service",
        "name": "{{ $service['title'] }}",
        "description": "{{ $service['description'] }}",
        "provider": {
            "@type": "Organization",
            "name": "{{ $settings['company_name'] }}",
            "telephone": "{{ $settings['company_phone'] ?? '' }}",
            "email": "{{ $settings['company_email'] ?? '' }}"
        }
    }
    </script>
    <script src="https://kit.fontawesome.com/050b5dcfea.js" crossorigin="anonymous"></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('layouts.header')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-head via-blue-800 to-head text-white py-32 mt-20 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-head/50"></div>
            <!-- Animated Grid Background -->
            <div class="absolute inset-0 bg-grid-white/[0.05] animate-grid-fade"></div>
            <!-- Glowing Orbs -->
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-500/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-blue-600/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Animated Service Icon -->
                <div class="relative inline-block mb-8">
                    <div class="absolute inset-0 bg-blue-500/20 rounded-2xl blur-xl transform animate-blob"></div>
                    <div class="relative inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-white/10 to-white/5 rounded-2xl backdrop-blur-sm transform hover:scale-110 hover:rotate-6 transition-all duration-300 group">
                        <i class="{{ $service['icon'] }} text-5xl group-hover:text-blue-300 transition-colors"></i>
                    </div>
                </div>
                
                <!-- Animated Title -->
                <div class="relative">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-blue-100 via-white to-blue-100 animate-gradient">
                        {{ $service['title'] }}
                    </h1>
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-500/0 via-blue-500/30 to-blue-500/0 blur-lg opacity-50 animate-shine"></div>
                </div>

                <!-- Description with Gradient Border -->
                <div class="relative p-1 rounded-2xl bg-gradient-to-r from-blue-500/50 via-white/25 to-blue-500/50 backdrop-blur-sm">
                    <div class="bg-head/40 rounded-xl p-6 backdrop-blur-sm">
                        <p class="text-xl text-blue-100 leading-relaxed max-w-3xl mx-auto">
                            {{ $service['description'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider yang baru -->
        <div class="absolute left-0 right-0 bottom-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[100px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Overview Section -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-12">
                    <h2 class="text-2xl font-bold text-head mb-6">Overview</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $service['description'] }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Features List -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 transform hover:-translate-y-1 transition-all duration-300">
                        <h2 class="text-2xl font-bold text-head mb-8 flex items-center">
                            <span class="w-12 h-12 flex items-center justify-center bg-head/10 text-head rounded-xl mr-4">
                                <i class="fas fa-star text-xl"></i>
                            </span>
                            Layanan Kami
                        </h2>
                        <div class="space-y-6">
                            @foreach($service['features'] as $feature)
                            <div class="flex items-start group">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-br from-head to-blue-600 text-white transform group-hover:rotate-6 transition-transform duration-300">
                                    <i class="fas fa-check text-sm"></i>
                                </div>
                                <p class="ml-4 text-gray-600 group-hover:text-head transition-colors">{{ $feature }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Benefits List -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 transform hover:-translate-y-1 transition-all duration-300">
                        <h2 class="text-2xl font-bold text-head mb-8 flex items-center">
                            <span class="w-12 h-12 flex items-center justify-center bg-head/10 text-head rounded-xl mr-4">
                                <i class="fas fa-lightbulb text-xl"></i>
                            </span>
                            Keunggulan
                        </h2>
                        <div class="space-y-6">
                            @foreach($service['benefits'] as $benefit)
                            <div class="flex items-start group">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-br from-head to-blue-600 text-white transform group-hover:rotate-6 transition-transform duration-300">
                                    <i class="fas fa-plus text-sm"></i>
                                </div>
                                <p class="ml-4 text-gray-600 group-hover:text-head transition-colors">{{ $benefit }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="mt-20">
                    <div class="bg-gradient-to-br from-head to-blue-800 rounded-2xl p-12 shadow-xl relative overflow-hidden">
                        <div class="absolute inset-0 bg-grid-white/[0.05]"></div>
                        <div class="relative z-10">
                            <h3 class="text-3xl font-bold text-white mb-4 text-center">
                                Butuh Konsultasi?
                            </h3>
                            <p class="text-blue-100 mb-8 text-center text-lg">
                                Tim kami siap membantu memberikan solusi terbaik untuk kebutuhan teknologi Anda
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="/contact" class="inline-flex items-center px-8 py-4 bg-white text-head font-semibold rounded-xl hover:bg-blue-50 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-envelope mr-2"></i>
                                    Hubungi Kami
                                </a>
                                <a href="{{ route('layanan') }}" class="inline-flex items-center px-8 py-4 bg-head/20 text-white font-semibold rounded-xl hover:bg-head/30 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-sm">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <style>
        .animate-gradient {
            background-size: 200% auto;
            animation: gradient 8s linear infinite;
        }

        .animate-grid-fade {
            background-size: 30px 30px;
            background-image: linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                            linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            animation: grid-fade 2s ease-in-out infinite alternate;
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animate-shine {
            animation: shine 3s ease-in-out infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        @keyframes grid-fade {
            0% { opacity: 0.3; }
            100% { opacity: 0.7; }
        }

        @keyframes blob {
            0% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(180deg); }
            100% { transform: scale(1) rotate(360deg); }
        }

        @keyframes shine {
            0% { opacity: 0; transform: translateX(-100%); }
            50% { opacity: 0.5; transform: translateX(0); }
            100% { opacity: 0; transform: translateX(100%); }
        }

        .delay-1000 {
            animation-delay: 1s;
        }
    </style>
</body>
</html> 