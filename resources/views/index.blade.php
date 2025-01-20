<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['pt1'] ?? 'Beranda' }} - {{ $settings['company_name'] ?? 'PT. Digital Raya Fokus' }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $settings['company_description'] ?? 'Penyedia solusi teknologi informasi terpercaya untuk transformasi digital bisnis Anda' }}">
    <meta name="keywords" content="{{ $settings['company_keywords'] ?? 'teknologi informasi, IT solution, digital transformation, software development, web development, mobile app development, IT consultant' }}">
    <meta name="author" content="{{ $settings['company_name'] ?? 'PT. Digital Raya Fokus' }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $settings['pt1'] ?? 'Beranda' }} - {{ $settings['company_name'] ?? 'PT. Digital Raya Fokus' }}">
    <meta property="og:description" content="{{ $settings['company_description'] ?? 'Penyedia solusi teknologi informasi terpercaya untuk transformasi digital bisnis Anda' }}">
    <meta property="og:image" content="{{ asset($settings['company_logo'] ?? 'asset/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    <!-- Schema.org Markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ $settings['company_name'] ?? 'PT. Digital Raya Fokus' }}",
        "description": "{{ $settings['company_description'] ?? 'Penyedia solusi teknologi informasi terpercaya' }}",
        "url": "{{ url('/') }}",
        "logo": "{{ asset($settings['company_logo'] ?? 'asset/logo.png') }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "{{ $settings['company_phone'] ?? '' }}",
            "email": "{{ $settings['company_email'] ?? '' }}",
            "contactType": "customer service"
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $settings['company_address'] ?? '' }}"
        }
    }
    </script>
    <link rel="icon" href="{{ $settings['company_logo'] ?? 'asset/logo.png' }}" type="image/x-icon">
    <script src="https://kit.fontawesome.com/050b5dcfea.js" crossorigin="anonymous"></script>
    @vite('resources/css/app.css')
    <style>
        .slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        
        .slide.active {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-white">
    @include('layouts.header')

    <!-- Hero Section -->
    <div class="relative h-screen overflow-hidden">
        <div class="absolute inset-0 z-0">
            <!-- Slide 1 -->
            <div class="slide opacity-100">
                @if(isset($settings['ic1']) && $settings['ic1'])
                <img src="{{ asset('storage/' . $settings['ic1']) }}" 
                     alt="card1 {{ $settings['ic1'] ?? '' }}" 
                     class="w-full h-full object-cover">
            @else
                <img src="{{ asset('asset/image1.jpeg') }}" 
                     alt="slide1" 
                     class="w-full h-full object-cover">
            @endif
                <div class="absolute inset-0 bg-foot/50"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center px-4 max-w-5xl mx-auto">
                        <h1 class="text-4xl md:text-7xl font-bold text-white mb-8 leading-tight">
                            {{ $settings['tc1'] ?? 'Transformasi Digital untuk Masa Depan' }}
                        </h1>
                        <p class="text-xl md:text-2xl text-white/90 mb-12 leading-relaxed">
                            {{ $settings['dc1'] ?? 'Solusi teknologi inovatif untuk mengakselerasi pertumbuhan bisnis Anda' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide opacity-0">
                @if(isset($settings['ic2']) && $settings['ic2'])
                <img src="{{ asset('storage/' . $settings['ic2']) }}" 
                     alt="card2 {{ $settings['ic2'] ?? '' }}" 
                     class="w-full h-full object-cover">
            @else
                <img src="{{ asset('asset/image2.jpeg') }}" 
                     alt="slide2" 
                     class="w-full h-full object-cover">
            @endif
                <div class="absolute inset-0 bg-foot/50"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center px-4 max-w-5xl mx-auto">
                        <h1 class="text-4xl md:text-7xl font-bold text-white mb-8 leading-tight">
                            {{ $settings['tc2'] ?? 'Solusi Digital Terpercaya' }}
                        </h1>
                        <p class="text-xl md:text-2xl text-white/90 mb-12 leading-relaxed">
                            {{ $settings['dc2'] ?? 'Tingkatkan efisiensi dan produktivitas bisnis Anda dengan teknologi modern' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="absolute inset-x-0 bottom-10 z-10 flex justify-center gap-4">
            <a href="/contact" class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transform hover:scale-105 transition-all duration-300">
                Mulai Sekarang
            </a>
            <a href="/profil" class="px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-lg transform hover:scale-105 transition-all duration-300">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>

    <!-- Services Section -->
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    {{ $settings['index_headline'] ?? 'Layanan Unggulan' }}
                </h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Kami menyediakan berbagai layanan teknologi informasi untuk membantu bisnis Anda berkembang di era digital
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($layanans->take(3) as $layanan)
                <a href="{{ route('layanan.show', $layanan->slug) }}" class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors">
                        <i class="{{ $layanan->icon }} text-2xl text-blue-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600">{{ $layanan->title }}</h3>
                    <p class="text-gray-600">{{ $layanan->description }}</p>
                </a>
                @endforeach
            </div>

            <div class="text-center mt-16">
                <a href="/layanan" class="inline-flex items-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all duration-300 group">
                    <span>Jelajahi Semua Layanan</span>
                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            let currentSlide = 0;

            window.showSlide = function(index) {
                slides.forEach(slide => slide.style.opacity = '0');
                slides[index].style.opacity = '1';
            }

            window.nextSlide = function() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }

            window.prevSlide = function() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            }

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight') nextSlide();
                if (e.key === 'ArrowLeft') prevSlide();
            });

            // Auto slide every 8 seconds (diperlambat dari 5 detik menjadi 8 detik)
            setInterval(nextSlide, 8000);
        });
    </script>
</body>
</html>
