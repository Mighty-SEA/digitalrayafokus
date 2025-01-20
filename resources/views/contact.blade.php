<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['pt5'] ?? 'Contact' }} - {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}</title>
    <meta name="description" content="{{ $settings['company_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['company_keywords'] ?? '' }}">
    <link rel="icon" href="{{ asset($settings['company_favicon'] ?? 'asset/logo.png') }}" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('layouts.header')

    <section id="contact-page" class="pt-28 pb-16">
        <div class="container mx-auto px-4">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-5xl font-bold text-head mb-4">{{ $settings['contact_title'] ?? 'Hubungi Kami' }}</h1>
                <div class="w-20 h-1 bg-yellow-400 mx-auto mb-6"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ $settings['contact_subtitle'] ?? 'Berikut adalah informasi kontak kami untuk mendapatkan informasi lebih lanjut mengenai layanan kami.' }}</p>
            </div>

            <!-- Contact Info & Map Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-7xl mx-auto">
                <!-- Contact Information -->
                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="space-y-8">
                        <!-- Company Info -->
                        <div class="flex items-center space-x-4 mb-8">
                            @if(isset($settings['company_logo2']) && $settings['company_logo2'])
                            <img src="{{ asset('storage/' . $settings['company_logo2']) }}" 
                            alt="Logo {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}" 
                                 class="relative w-full max-w-lg mx-auto rounded-2xl transform group-hover:-translate-y-2 transition-transform duration-500">
                        @else
                            <img src="{{ asset('asset/logo.png') }}" 
                            alt="Logo {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}" 
                                 class="w-12 h-12">
                        @endif
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $settings['company_name'] ?? 'Digital Raya Fokus' }}</h3>
                                <p class="text-gray-500">{{ $settings['company_tagline'] ?? 'Solusi Digital Terpercaya' }}</p>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $settings['contact_address_label'] ?? 'Alamat Kantor' }}</h4>
                                <p class="text-gray-600 leading-relaxed">{{ $settings['company_address'] ?? 'Alamat belum diatur' }}</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-phone-alt text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $settings['contact_phone_label'] ?? 'Telepon' }}</h4>
                                <p class="text-gray-600">
                                    <a href="tel:{{ $settings['company_phone'] }}" class="hover:text-blue-600 transition-colors">
                                        {{ $settings['company_phone'] ?? 'Nomor telepon belum diatur' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-yellow-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $settings['contact_email_label'] ?? 'Email' }}</h4>
                                <p class="text-gray-600">
                                    <a href="mailto:{{ $settings['company_email'] }}" class="hover:text-blue-600 transition-colors">
                                        {{ $settings['company_email'] ?? 'Email belum diatur' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        <div class="pt-6 border-t">
                            <div class="flex space-x-4">
                                @if($settings['social_facebook'] ?? false)
                                <a href="{{ $settings['social_facebook'] }}" class="w-10 h-10 bg-[#1877F2] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90 transition-all duration-300 hover:scale-110">
                                    <i class="fa-brands fa-facebook-f text-lg"></i>
                                </a>
                                @endif
                                
                                @if($settings['social_instagram'] ?? false)
                                <a href="{{ $settings['social_instagram'] }}" class="w-10 h-10 bg-gradient-to-r from-[#833AB4] via-[#FD1D1D] to-[#F77737] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90 transition-all duration-300 hover:scale-110">
                                    <i class="fa-brands fa-instagram text-lg"></i>
                                </a>
                                @endif
                                
                                @if($settings['social_twitter'] ?? false)
                                <a href="{{ $settings['social_twitter'] }}" class="w-10 h-10 bg-[#1DA1F2] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90 transition-all duration-300 hover:scale-110">
                                    <i class="fa-brands fa-twitter text-lg"></i>
                                </a>
                                @endif
                                
                                @if($settings['social_youtube'] ?? false)
                                <a href="{{ $settings['social_youtube'] }}" class="w-10 h-10 bg-[#FF0000] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90 transition-all duration-300 hover:scale-110">
                                    <i class="fa-brands fa-youtube text-lg"></i>
                                </a>
                                @endif
                                
                                @if($settings['social_whatsapp'] ?? false)
                                <a href="https://wa.me/{{ $settings['social_whatsapp'] }}" class="w-10 h-10 bg-[#25D366] text-white rounded-lg flex items-center justify-center hover:bg-opacity-90 transition-all duration-300 hover:scale-110">
                                    <i class="fa-brands fa-whatsapp text-lg"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                    <iframe 
                        src="{{ $settings['company_maps'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.65892832923!2d107.59358089999999!3d-7.049305200000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68eb9eed802849%3A0xbd60aa64d1f1b8bd!2sJl.%20Kapten%20Sarwono%20No.32%2C%20Banjaran%20Wetan%2C%20Kec.%20Banjaran%2C%20Kabupaten%20Bandung%2C%20Jawa%20Barat%2040377!5e0!3m2!1sen!2sid!4v1734612867059!5m2!1sen!2sid' }}"
                        width="100%" 
                        height="100%" 
                        style="border:0; min-height: 400px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')
</body>
</html>
