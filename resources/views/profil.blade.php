<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['pt2'] ?? 'Profil' }} - {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}</title>
    <meta name="description" content="{{ $settings['company_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['company_keywords'] ?? '' }}">
    <link rel="icon" href="{{ asset($settings['company_logo'] ?? 'asset/logo.png') }}" type="image/x-icon">
    <script src="https://kit.fontawesome.com/050b5dcfea.js" crossorigin="anonymous"></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-white">
    @include('layouts.header')

    <!-- Hero Section -->
    <section class="pt-28 pb-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center">
                <!-- Text Content -->
                <div class="w-full lg:w-1/2 mb-12 lg:mb-0">
                    <div class="max-w-lg">
                        <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-4 block">Tentang Kami</span>
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                            Tentang {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}
                        </h1>
                        <div class="w-20 h-1 bg-blue-600 mb-8"></div>
                        <p class="text-lg text-gray-600 leading-relaxed mb-8">
                            {{ $settings['company_profile'] ?? 'PT Digital Raya Fokus adalah perusahaan teknologi informasi yang berfokus pada penyediaan solusi digital komprehensif untuk mendukung transformasi bisnis.' }}
                        </p>
                        <div class="flex space-x-4">
                            <a href="/contact" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 group">
                                <span>Hubungi Kami</span>
                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="/portofolio" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-300">
                                <span>Portofolio</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="w-full lg:w-1/2">
                    <div class="relative group">
                        <div class="absolute inset-0 rounded-full transform group-hover:scale-105 transition-transform duration-500"></div>
                        @if(isset($settings['company_logo2']) && $settings['company_logo2'])
                <img src="{{ asset('storage/' . $settings['company_logo2']) }}" 
                alt="Logo {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}" 
                     class="relative w-full max-w-lg mx-auto rounded-2xl transform group-hover:-translate-y-2 transition-transform duration-500">
            @else
                <img src="{{ asset('asset/logo2.png') }}" 
                alt="Logo {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}" 
                     class="relative w-full max-w-lg mx-auto rounded-2xl transform group-hover:-translate-y-2 transition-transform duration-500">
            @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Visi & Misi Kami</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Visi Card dengan Efek Modern -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    <!-- Background Patterns -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/5 to-blue-500/10 rounded-full -mr-20 -mt-20 transform group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-blue-500/5 to-blue-500/10 rounded-full -ml-16 -mb-16 transform group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <!-- Icon Container dengan Efek -->
                    <div class="relative mb-8">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl mb-6 mx-auto transform group-hover:rotate-6 transition-all duration-300 shadow-lg">
                            <i class="fa-solid fa-eye text-2xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <!-- Glow Effect -->
                        <div class="absolute inset-0 bg-blue-600/20 rounded-2xl blur-2xl -z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <!-- Content -->
                    <div class="relative z-10">
                        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-800 group-hover:from-blue-700 group-hover:to-blue-900 transition-all duration-300">
                                Visi
                            </span>
                        </h2>
                        <div class="w-20 h-1 bg-gradient-to-r from-blue-600 to-blue-700 mx-auto mb-6 transform origin-left group-hover:scale-x-125 transition-transform duration-300"></div>
                        <p class="text-gray-600 leading-relaxed text-center relative">
                            <span class="relative inline-block">
                                {{ $settings['company_visi'] ?? 'Menjadi pionir dalam menyediakan solusi teknologi yang inovatif dan memberikan kontribusi positif dalam mengubah lanskap bisnis melalui teknologi informasi.' }}
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></span>
                            </span>
                        </p>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-6 -right-6 w-12 h-12 bg-blue-50 rounded-full opacity-0 group-hover:opacity-100 transform group-hover:translate-y-2 transition-all duration-500"></div>
                    <div class="absolute -top-6 -left-6 w-12 h-12 bg-blue-50 rounded-full opacity-0 group-hover:opacity-100 transform group-hover:translate-y-2 transition-all duration-500"></div>
                </div>

                <!-- Misi Card dengan List yang Lebih Menarik -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/5 to-blue-500/10 rounded-full -mr-20 -mt-20 transform group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-blue-500/5 to-blue-500/10 rounded-full -ml-16 -mb-16 transform group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <!-- Icon Header -->
                    <div class="relative mb-8">
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl mb-6 transform group-hover:rotate-6 transition-all duration-300 shadow-lg">
                            <i class="fa-solid fa-rocket text-2xl group-hover:scale-110 transition-transform"></i>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 relative">Misi</h2>
                    
                    <!-- Mission List -->
                    <ul class="space-y-4 relative">
                        @php
                            $misiArray = explode("\n", $settings['company_misi'] ?? '');
                            $misiArray = array_map('trim', $misiArray);
                            $misiArray = array_filter($misiArray);
                            
                            if (empty($misiArray)) {
                                $misiArray = [
                                    'Memberikan layanan TI berkualitas tinggiiiiii',
                                    'Mengembangkan solusi digital inovatif',
                                    'Membangun kemitraan jangka panjang',
                                    'Berkontribusi pada ekosistem digital'
                                ];
                            }
                        @endphp
                        @foreach($misiArray as $misi)
                        <li class="flex items-start group/item hover:transform hover:translate-x-2 transition-all duration-300">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-blue-600 group-hover/item:from-blue-600 group-hover/item:to-blue-700 transition-all duration-300 shadow-sm">
                                <i class="fa-solid fa-check text-blue-600 group-hover/item:text-white transition-colors"></i>
                            </div>
                            <span class="text-gray-600 group-hover/item:text-gray-900 transition-colors">{{ trim($misi) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')
</body>
</html>
