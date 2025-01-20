<footer class="bg-foot text-white pt-16 pb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Company Info -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 group">
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
                        <h3 class="text-xl font-bold mb-1">{{ $settings['company_name'] }}</h3>
                        <div class="w-20 h-0.5 bg-blue-500 transform origin-left group-hover:scale-x-150 transition-transform duration-300"></div>
                    </div>
                </div>
                <p class="text-gray-400 leading-relaxed">
                    {{ $settings['company_description'] }}
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-6 relative inline-block group">
                    Layanan Kami
                    <div class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-500 transform origin-left group-hover:scale-x-100 transition-transform duration-300"></div>
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Konsultasi Teknologi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Pengembangan Software</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Infrastruktur Teknologi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Layanan Manajemen TI</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Pelatihan dan Sertifikasi</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-6 relative inline-block group">
                    Hubungi Kami
                    <div class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-500 transform origin-left group-hover:scale-x-100 transition-transform duration-300"></div>
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3 group">
                        <div class="w-10 h-10 rounded-lg bg-blue-600/10 flex items-center justify-center group-hover:bg-blue-600 transition-all duration-300">
                            <i class="fas fa-map-marker-alt text-blue-400 group-hover:text-white transition-colors"></i>
                        </div>
                        <span class="text-gray-400 group-hover:text-blue-400 transition-colors duration-300 flex-1">{{ $settings['company_address'] }}</span>
                    </li>
                    <li class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-lg bg-blue-600/10 flex items-center justify-center group-hover:bg-blue-600 transition-all duration-300">
                            <i class="fas fa-phone-alt text-blue-400 group-hover:text-white transition-colors"></i>
                        </div>
                        <a href="tel:{{ $settings['company_phone'] }}" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
                            {{ $settings['company_phone'] }}
                        </a>
                    </li>
                    <li class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-lg bg-blue-600/10 flex items-center justify-center group-hover:bg-blue-600 transition-all duration-300">
                            <i class="fas fa-envelope text-blue-400 group-hover:text-white transition-colors"></i>
                        </div>
                        <a href="mailto:{{ $settings['company_email'] }}" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
                            {{ $settings['company_email'] }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-mint mt-12 pt-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} {{ $settings['company_name'] }}. All rights reserved.</p>
        </div>
    </div>
</footer>
