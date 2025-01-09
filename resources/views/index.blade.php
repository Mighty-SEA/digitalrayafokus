<!DOCTYPE html>
<html lang="en">
<script src="https://kit.fontawesome.com/050b5dcfea.js" crossorigin="anonymous"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda')</title>
    <link rel="icon" href="asset/logo.png" type="image/x-icon">
    @vite('resources/css/app.css')
</head>
<body class="pt-18">
    @include('layouts.header')

    <style>
        /* Custom animation for text */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    
        .animate-fade-in-down {
            animation: fadeInDown 1s ease-out;
        }
    
        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out;
        }
    
        /* Slider Styles */
        .slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
    
        .slide.opacity-100 {
            opacity: 1;
        }
    
        .slide.hidden {
            display: none;
        }
    </style>
    
    <!-- Slider Section -->
    <div class="relative h-screen mt-16 md:mt-0 overflow-hidden">
        <div class="absolute inset-0 h-full flex items-center justify-center">
            <!-- Slide 1 -->
            <div class="slide opacity-0 hidden">
                <img src="asset/image1.jpeg" alt="Image 1" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-head opacity-30"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 animate-slide">
                    <h2 class="text-2xl md:text-5xl font-bold text-white animate-fade-in-down">Selamat Datang di PT. Digital Raya Fokus</h2>
                    <p class="text-md md:text-xl text-white mt-2 animate-fade-in-up">Mitra terpercaya Anda untuk solusi IT yang inovatif dan profesional.</p>
                </div>
            </div>
    
            <div class="slide opacity-0 hidden">
                <img src="asset/image2.jpeg" alt="Image 2" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-head opacity-30"></div>
                <div class="absolute inset-0 flex items-center px-8 md:px-16">
                    <div class="max-w-sm">
                        <h2 class="text-2xl md:text-4xl font-bold text-white animate-fade-in-down leading-snug">
                            Konsultasikan Kebutuhan Anda dan Dapatkan Solusi Terbaik
                        </h2>
                        <a href="/kontak" class="mt-6 px-6 py-3 bg-head hover:bg-mint text-white font-semibold text-lg rounded-md block text-center animate-fade-in-up">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
            
        </div>            
    
    </div>
    
    <script>
        let slideIndex = 0;
        const slides = document.querySelectorAll('.slide');
        const slideDuration = 10000; // 10 seconds
    
        // Function to show the current slide
        function showSlides(index) {
            slides.forEach((slide, i) => {
                slide.classList.add('opacity-0', 'hidden');
                slide.classList.remove('opacity-100');
                if (i === index) {
                    slide.classList.remove('hidden');
                    setTimeout(() => {
                        slide.classList.add('opacity-100');
                        slide.classList.remove('opacity-0');
                    }, 10);
                }
            });
        }
    
        // Function to navigate slides
        function nextSlide() {
            slideIndex = (slideIndex + 1) % slides.length;
            showSlides(slideIndex);
        }
    
        function prevSlide() {
            slideIndex = (slideIndex - 1 + slides.length) % slides.length;
            showSlides(slideIndex);
        }
    
        // Initialize slider
        showSlides(slideIndex);
    
        // Automatic slide transition
        setInterval(nextSlide, slideDuration);
    
        // Keyboard navigation
        document.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowRight') {
                nextSlide();
            } else if (event.key === 'ArrowLeft') {
                prevSlide();
            }
        });
</script>    

<section class="py-16 bg-gray-100">
    <!-- Judul -->
    <div class="text-center mb-12">
        <h3 class="text-3xl md:text-5xl font-bold text-head">
            Solusi untuk Segala<br> Kebutuhan Anda
        </h3>
    </div>

    <!-- Card Section -->
    <div class="container mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1 -->
        <div class="bg-white shadow-lg p-6 rounded-lg text-center">
            <div class="flex items-center justify-center w-24 h-24 mb-4 bg-blue-100 text-green-500 rounded-full mx-auto">
                <i class="fa-regular fa-handshake text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">
                Konsultasi Teknologi
            </h3>
            <p class="text-gray-600 text-center">
                Dapatkan solusi tepat untuk kebutuhan bisnis Anda dengan bantuan ahli teknologi kami.
            </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center justify-center w-24 h-24 mb-4 bg-blue-100 text-green-500 rounded-full mx-auto">
                <i class="fa-solid fa-code text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">
                Software  Development
            </h3>
            <p class="text-gray-600 text-center">
                Kami mengembangkan aplikasi sesuai kebutuhan untuk mendukung bisnis Anda.
            </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center justify-center w-24 h-24 mb-4 bg-blue-100 text-green-500 rounded-full mx-auto">
                <i class="fa-solid fa-list-check text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">
                Layanan Manajemen IT
            </h3>
            <p class="text-gray-600 text-center">
                Serahkan pengelolaan IT kepada kami dan fokus pada bisnis Anda.
            </p>
        </div>
    </div>
    <br>
    <center>
    <button href="/kontak" class="mt-4 px-4 py-1 bg-head hover:bg-mint text-white font-semibold text-lg rounded-md block text-center animate-fade-in-up">
        Selengkapnya
    </button></center>
</section>
    @include('layouts.footer')
</body>
</html>
