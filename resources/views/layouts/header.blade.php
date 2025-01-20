@php
use App\Models\Settings;
use App\Models\Layanan;

// Ambil semua settings dalam satu query
$settings = Settings::pluck('value', 'key')->all();

// Ambil layanan yang aktif
$layanans = Layanan::where('is_active', true)
                   ->orderBy('order')
                   ->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>{{ $settings['pt1'] ?? 'Beranda' }} - {{ $settings['company_name'] ?? 'PT. Digital Raya Fokus' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset($settings['company_logo'] ?? 'asset/logo.png') }}" type="image/x-icon">

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Navbar -->
    <nav id="navbar" class="fixed border-b border-head shadow-lg p-4 transition-all duration-300 ease-in-out z-50 bg-head text-white top-0 left-0 right-0 mx-0 rounded-none backdrop-blur-sm">
        <div class="container mx-auto flex justify-between items-center px-4">
            <!-- Logo dan Nama -->
            <div class="flex items-center space-x-4">
                @if(isset($settings['company_logo']) && $settings['company_logo'])
                <img src="{{ asset('storage/' . $settings['company_logo']) }}" 
                     alt="logo {{ $settings['company_name'] ?? '' }}" 
                     class="w-12 h-12">
            @else
                <img src="{{ asset('asset/logo.png') }}" 
                     alt="logo" 
                     class="w-12 h-12">
            @endif
                <a id="brand" href="{{ url('/') }}" class="font-bold text-2xl text-white transition-colors duration-300 hover:text-yellow-400">{{ $settings['company_name'] ?? 'Digital Raya Fokus' }}</a>
            </div>

            <!-- Links -->
            <ul class="hidden md:flex items-center space-x-8">
                <li><a href="{{ url('/') }}" class="font-semibold text-yellow-400 nav-link hover:text-blue-400 transition-colors duration-200 py-2">{{ $settings['pt1'] ?? 'Beranda' }}</a></li>
                <li><a href="{{ url('/profil') }}" class="font-semibold nav-link hover:text-yellow-400 transition-colors duration-200 py-2">{{ $settings['pt2'] ?? 'Profil' }}</a></li>
                <li><a href="{{ url('/portofolio') }}" class="font-semibold nav-link hover:text-yellow-400 transition-colors duration-200 py-2">{{ $settings['pt3'] ?? 'Portofolio' }}</a></li>
                <li class="relative group">
                    <button class="font-semibold nav-link hover:text-yellow-400 flex items-center focus:outline-none transition-colors duration-200 py-2">
                        <span><a href="{{ url('/layanan') }}">{{ $settings['pt4'] ?? 'Layanan' }}</a></span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <ul class="absolute right-0 mt-2 w-64 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 transform -translate-y-2 scale-95 transition-all duration-200 invisible group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 group-hover:scale-100 z-10">
                        @foreach($layanans as $layanan)
                        <li>
                            <a href="{{ route('layanan.show', $layanan->slug) }}" 
                               class="block px-6 py-3 text-gray-800 hover:bg-yellow-50 hover:text-yellow-600 {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }} transition-colors duration-200">
                                {{ $layanan->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ url('/contact') }}" class="font-semibold nav-link hover:text-yellow-400 transition-colors duration-200 py-2">{{ $settings['pt5'] ?? 'Contact' }}</a></li>
            </ul>

            <!-- Mobile Menu Button -->
            <button id="menuButton" class="md:hidden text-white hover:text-yellow-400 transition-colors duration-200">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden fixed inset-0 z-50">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity duration-300"></div>
            
            <!-- Menu Content -->
            <div class="absolute right-0 top-0 h-full w-full md:w-[85%] lg:w-[50%] bg-white/95 backdrop-blur-sm shadow-2xl transform transition-transform duration-300">
                <!-- Header Mobile Menu -->
                <div class="flex justify-between items-center p-5 bg-head">
                    <div class="flex items-center space-x-3">
                        @if(isset($settings['company_logo']) && $settings['company_logo'])
                        <img src="{{ asset('storage/' . $settings['company_logo']) }}" 
                             alt="logo {{ $settings['company_name'] ?? '' }}" 
                             class="w-12 h-12">
                    @else
                        <img src="{{ asset('images/logo.jpg') }}" 
                             alt="logo" 
                             class="w-12 h-12">
                    @endif
                        <div class="flex flex-col">
                            <span class="font-bold text-lg md:text-xl text-white">{{ $settings['company_name'] ?? 'Digital Raya Fokus' }}</span>
                            <span class="text-xs md:text-sm text-gray-200">Transformasi Digital</span>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="py-4 bg-white">
                    <nav class="space-y-1 max-w-3xl mx-auto">
                        <a href="{{ url('/') }}" class="flex items-center px-5 py-4 text-base md:text-lg font-medium {{ request()->is('/') ? 'text-yellow-400 bg-gray-100' : 'text-gray-900' }} hover:bg-gray-100 transition-colors duration-200">
                            <i class="fas fa-home w-5 h-5 md:w-6 md:h-6 mr-3 {{ request()->is('/') ? 'text-yellow-400' : 'text-gray-400' }}"></i>
                            {{ $settings['pt1'] ?? 'Beranda' }}
                        </a>
                        <a href="{{ url('/profil') }}" class="flex items-center px-5 py-4 text-base md:text-lg font-medium {{ request()->is('profil') ? 'text-yellow-400 bg-gray-100' : 'text-gray-900' }} hover:bg-gray-100 transition-colors duration-200">
                            <i class="fas fa-building w-5 h-5 md:w-6 md:h-6 mr-3 {{ request()->is('profil') ? 'text-yellow-400' : 'text-gray-400' }}"></i>
                            {{ $settings['pt2'] ?? 'Profil' }}
                        </a>
                        <a href="{{ url('/portofolio') }}" class="flex items-center px-5 py-4 text-base md:text-lg font-medium {{ request()->is('portofolio') ? 'text-yellow-400 bg-gray-100' : 'text-gray-900' }} hover:bg-gray-100 transition-colors duration-200">
                            <i class="fas fa-briefcase w-5 h-5 md:w-6 md:h-6 mr-3 {{ request()->is('portofolio') ? 'text-yellow-400' : 'text-gray-400' }}"></i>
                            {{ $settings['pt3'] ?? 'Portofolio' }}
                        </a>
                        
                        <!-- Layanan Dropdown -->
                        <div class="relative bg-white">
                            <button id="mobileDropdownButton" class="flex items-center justify-between w-full px-5 py-4 text-base md:text-lg font-medium text-gray-900 hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex items-center">
                                    <i class="fas fa-cogs w-5 h-5 md:w-6 md:h-6 mr-3 text-gray-400"></i>
                                    <span>{{ $settings['pt4'] ?? 'Layanan' }}</span>
                                </div>
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="mobileDropdownMenu" class="hidden bg-white border-y border-gray-100">
                                @foreach($layanans as $layanan)
                                <a href="{{ route('layanan.show', $layanan->slug) }}" 
                                   class="flex items-center px-12 py-4 text-sm md:text-base text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                                    <span class="w-2 h-2 md:w-3 md:h-3 bg-blue-500 rounded-full mr-3"></span>
                                    {{ $layanan->title }}
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ url('/contact') }}" class="flex items-center px-5 py-4 text-base md:text-lg font-medium {{ request()->is('contact') ? 'text-yellow-400 bg-gray-100' : 'text-gray-900' }} hover:bg-gray-100 transition-colors duration-200">
                            <i class="fas fa-envelope w-5 h-5 md:w-6 md:h-6 mr-3 {{ request()->is('contact') ? 'text-yellow-400' : 'text-gray-400' }}"></i>
                            {{ $settings['pt5'] ?? 'Contact' }}
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </nav>

    <script>
        const navbar = document.getElementById('navbar');
        const menuButton = document.getElementById('menuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const brand = document.getElementById('brand');
        const mobileDropdownButton = document.getElementById('mobileDropdownButton');
        const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');
     
    mobileDropdownButton.addEventListener('click', () => {
        mobileDropdownMenu.classList.toggle('hidden');
    });


        // Show/hide mobile menu
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Change navbar style on scroll
         window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
          // Tambahkan gaya saat scroll
          brand.classList.remove('text-white');
          brand.classList.add('text-black');
          navbar.classList.remove('bg-head', 'text-white', 'top-0', 'left-0', 'right-0', 'mx-0', 'rounded-none');
          navbar.classList.add('bg-white','top-4', 'left-4', 'right-4', 'rounded-lg', 'mx-4');
        } else {
          // Kembalikan gaya awal
          brand.classList.remove('text-black');
          brand.classList.add('text-white');
          navbar.classList.add('bg-head', 'text-white', 'top-0', 'left-0', 'right-0', 'mx-0', 'rounded-none');
          navbar.classList.remove('bg-white', 'top-4', 'left-4', 'right-4', 'rounded-lg', 'mx-4');
        }
      });

        // Menyembunyikan menu ketika mengklik di luar menu
        document.addEventListener('click', (event) => {
            if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        
    </script>
</head>