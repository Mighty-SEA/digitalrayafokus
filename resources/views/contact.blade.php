<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="icon" href="asset/logo.png" type="image/x-icon">
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.header')

    <!-- Halaman Kontak -->
    <section id="contact-page" class="pt-28 pb-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <!-- Judul Halaman -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-5xl font-bold text-head font-bold">{{ $settings->contact_title ?? 'Hubungi Kami' }}</h1>
                <p class="text-black mt-4">{{ $settings->contact_description ?? 'Berikut adalah informasi kontak kami untuk mendapatkan informasi lebih lanjut mengenai layanan kami.' }}</p>
            </div>

            <!-- Google Maps Section -->
            <div class="mb-12">
                <iframe src="{{ $settings->maps_url ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.65892832923!2d107.59358089999999!3d-7.049305200000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68eb9eed802849%3A0xbd60aa64d1f1b8bd!2sJl.%20Kapten%20Sarwono%20No.32%2C%20Banjaran%20Wetan%2C%20Kec.%20Banjaran%2C%20Kabupaten%20Bandung%2C%20Jawa%20Barat%2040377!5e0!3m2!1sen!2sid!4v1734612867059!5m2!1sen!2sid' }}"
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

         <!-- Kontak Perusahaan -->
         <div class="bg-biru text-white p-6 rounded-lg shadow-lg flex flex-col md:flex-row items-center max-w-3xl mx-auto">
            <!-- Konten Kontak -->
            <div class="flex-1">
                <h3 class="text-lg font-bold mb-4">{{ $settings->company_name ?? 'Kontak Perusahaan' }}</h3>
                <p class="text-sm mb-6">{{ $settings->contact_tagline ?? 'Kami siap membantu kebutuhan Anda dengan layanan terbaik dan respons cepat. Hubungi kami sekarang!' }}</p>
                <div class="grid gap-4">
        
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-sm">Alamat</h4>
                            <p class="text-sm leading-5">{!! nl2br(e($settings->address ?? 'Kapten Sarwono No.32, Banjaran Wetan, Kabupaten Bandung, Jawa Barat 40377 Indonesia')) !!}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                            <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-sm">Telepon</h4>
                            <p class="text-sm"><a href="tel:{{ $settings->phone ?? '+622745304851' }}" class="text-white hover:underline">{{ $settings->phone ?? '+62 896-9605-9684' }}</a></p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-sm">Email</h4>
                            <p class="text-sm"><a href="mailto:{{ $settings->email ?? 'idigitalrayafokus@gmail.com' }}" class="text-white hover:underline">{{ $settings->email ?? 'idigitalrayafokus@gmail.com' }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Gambar -->
            <div class="mt-6 md:mt-0 md:ml-8 w-full md:w-auto">
                <img src="{{ asset($settings->logo ?? 'asset/logofs.png') }}" alt="{{ $settings->company_name ?? 'Kontak Perusahaan' }}" class="w-full md:w-60 md:h-60 object-contain">
            </div>
        </div>
        
    

    </section>

    @include('layouts.footer')
</body>
</html>
