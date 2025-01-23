## 2. LANDASAN TEORI

### 2.1 Faktur
Faktur atau invoice adalah dokumen komersial yang memiliki peran vital dalam transaksi bisnis sebagai bukti resmi pembelian barang atau jasa. Dokumen ini berfungsi sebagai catatan terperinci mengenai transaksi yang terjadi antara penjual dan pembeli, mencakup informasi penting seperti daftar barang atau jasa yang dibeli, kuantitas, harga satuan, total harga, serta informasi pembayaran.

Dalam praktik bisnis modern, faktur tidak hanya berfungsi sebagai bukti transaksi, tetapi juga sebagai instrumen penting dalam sistem akuntansi dan perpajakan. Faktur menjadi dasar pencatatan dalam pembukuan baik bagi penjual maupun pembeli. Untuk keperluan pajak, terutama Pajak Pertambahan Nilai (PPN), faktur pajak yang valid merupakan dokumen wajib yang harus diterbitkan oleh Pengusaha Kena Pajak (PKP).

Seiring perkembangan teknologi, penggunaan faktur elektronik (e-invoice) semakin meluas. E-invoice menawarkan berbagai keuntungan seperti efisiensi waktu, pengurangan biaya operasional, kemudahan penyimpanan dan penelusuran, serta mendukung upaya paperless office. Sistem faktur elektronik juga memungkinkan integrasi langsung dengan sistem akuntansi dan manajemen keuangan perusahaan.

### 2.2 Laravel
Laravel merupakan framework PHP yang dikembangkan oleh Taylor Otwell dan pertama kali dirilis pada tahun 2011. Framework ini dibangun dengan fokus pada sintaksis yang elegan dan ekspresif, yang memungkinkan pengembang untuk menulis kode dengan lebih efisien dan produktif. Laravel mengadopsi prinsip "Convention over Configuration", yang berarti pengembang dapat fokus pada logika bisnis tanpa terlalu banyak menghabiskan waktu untuk konfigurasi.

Arsitektur MVC (Model-View-Controller) yang digunakan Laravel membantu dalam organisasi kode yang lebih terstruktur dan mudah dimaintain. Model bertanggung jawab untuk logika bisnis dan interaksi dengan database, View menangani presentasi data kepada pengguna, sedangkan Controller berfungsi sebagai perantara yang mengatur alur aplikasi dan komunikasi antara Model dan View.

Laravel dilengkapi dengan berbagai fitur modern yang mempercepat proses pengembangan aplikasi. Eloquent ORM (Object-Relational Mapping) menyederhanakan interaksi dengan database melalui pendekatan object-oriented. Blade templating engine menyediakan sintaks yang powerful untuk membuat tampilan yang dinamis. Artisan CLI (Command Line Interface) membantu automasi berbagai tugas pengembangan.

Sistem keamanan Laravel sangat komprehensif, mencakup proteksi terhadap berbagai jenis serangan web seperti SQL injection, cross-site scripting (XSS), dan cross-site request forgery (CSRF). Framework ini juga menyediakan sistem authentication dan authorization yang robust, serta integrasi dengan berbagai layanan pihak ketiga melalui ecosystem package yang luas.

### 2.3 Filament
Filament adalah framework admin panel modern yang dibangun di atas ekosistem Laravel. Framework ini mengadopsi TALL stack (Tailwind CSS, Alpine.js, Laravel, dan Livewire) yang memberikan pengalaman pengembangan yang seamless dan performa aplikasi yang optimal. Filament dirancang dengan fokus pada kemudahan penggunaan dan fleksibilitas, memungkinkan pengembang untuk membangun antarmuka admin yang kompleks dengan kode minimal.

Salah satu keunggulan utama Filament adalah form builder-nya yang sangat powerful. Form builder ini mendukung berbagai jenis input, validasi, dan layout yang dapat dikustomisasi sesuai kebutuhan. Pengembang dapat dengan mudah membuat form yang kompleks menggunakan komponen yang telah disediakan, termasuk upload file, rich text editor, date picker, dan berbagai jenis input lainnya.

Table builder Filament menawarkan fungsionalitas yang lengkap untuk menampilkan dan mengelola data dalam format tabel. Fitur-fitur seperti sorting, filtering, pagination, bulk actions, dan export data sudah tersedia secara built-in. Tabel juga dapat dikustomisasi dengan berbagai opsi tampilan dan interaksi sesuai kebutuhan aplikasi.

Framework ini juga menyediakan sistem widget yang fleksibel untuk membangun dashboard yang informatif. Widget dapat menampilkan berbagai jenis data seperti grafik, statistik, daftar aktivitas terbaru, dan informasi penting lainnya. Pengembang dapat membuat widget kustom atau menggunakan widget yang telah disediakan.

### 2.4 MySQL
MySQL adalah sistem manajemen basis data relasional (RDBMS) yang paling populer di dunia. Dikembangkan oleh Oracle Corporation, MySQL menjadi pilihan utama untuk berbagai jenis aplikasi karena performa yang tinggi, reliabilitas, dan kemudahan penggunaan. Database ini mendukung standar SQL (Structured Query Language) dan dapat digunakan pada berbagai platform operating system.

Arsitektur MySQL dirancang untuk menangani database berskala besar dengan jutaan record dan ribuan koneksi simultan. Sistem ini menggunakan model client-server, di mana server MySQL menangani semua instruksi database, sementara client dapat mengakses database dari berbagai aplikasi dan bahasa pemrograman melalui protokol TCP/IP.

Keamanan data dalam MySQL ditangani melalui sistem privileges yang komprehensif. Administrator dapat mengatur hak akses untuk setiap user pada level yang berbeda, mulai dari akses ke database, tabel, hingga operasi spesifik seperti SELECT, INSERT, UPDATE, dan DELETE. MySQL juga mendukung enkripsi data baik saat penyimpanan maupun transmisi.

MySQL menyediakan berbagai engine storage yang dapat dipilih sesuai kebutuhan aplikasi. InnoDB, engine default sejak MySQL 5.5, mendukung transaksi ACID (Atomicity, Consistency, Isolation, Durability) dan foreign key constraints. MyISAM, engine tradisional MySQL, optimal untuk operasi read-heavy dengan full-text indexing.

### 2.5 Visual Studio Code
Visual Studio Code (VS Code) adalah editor kode sumber yang dikembangkan oleh Microsoft dan dirilis pertama kali pada tahun 2015. Editor ini dibangun menggunakan framework Electron yang memungkinkannya berjalan secara cross-platform pada Windows, macOS, dan Linux. VS Code menggabungkan kesederhanaan editor kode dengan fitur-fitur powerful yang biasanya ditemukan pada Integrated Development Environment (IDE).

Salah satu keunggulan utama VS Code adalah sistem ekstensi yang sangat ekstensif. Pengembang dapat memperluas fungsionalitas editor dengan menginstal berbagai ekstensi dari marketplace resmi. Ekstensi ini mencakup berbagai aspek pengembangan seperti dukungan bahasa pemrograman, linting, debugging, integrasi git, dan tema tampilan. Ekosistem ekstensi yang kaya ini memungkinkan VS Code untuk beradaptasi dengan berbagai kebutuhan pengembangan.

IntelliSense, fitur code completion VS Code, menyediakan bantuan penulisan kode yang cerdas dengan menampilkan saran kode, parameter hints, dan quick info. Fitur ini didukung untuk berbagai bahasa pemrograman dan dapat ditingkatkan melalui ekstensi bahasa spesifik. VS Code juga menyediakan fitur debugging terintegrasi yang powerful, memungkinkan pengembang untuk memeriksa kode, mengatur breakpoints, dan mengevaluasi ekspresi secara real-time.

Git integration yang built-in memudahkan pengembang dalam mengelola version control langsung dari editor. Fitur ini mencakup visualisasi perubahan, penanganan conflicts, dan akses ke perintah git umum melalui command palette. Terminal terintegrasi juga memungkinkan pengembang untuk menjalankan perintah shell tanpa meninggalkan editor.

### 2.6 NGINX
NGINX (dibaca "engine-x") adalah server HTTP dan reverse proxy yang dikembangkan untuk mengatasi masalah C10K - kemampuan untuk menangani 10.000 koneksi bersamaan. Dirilis pertama kali oleh Igor Sysoev pada tahun 2004, NGINX telah menjadi salah satu web server paling populer di dunia karena arsitekturnya yang event-driven dan non-blocking.

Arsitektur asynchronous dan event-driven NGINX memungkinkannya untuk menangani beban tinggi dengan penggunaan memori yang efisien. Berbeda dengan server web tradisional yang menggunakan thread atau proses untuk setiap koneksi, NGINX menggunakan model worker process yang dapat menangani ribuan koneksi secara bersamaan dalam satu thread.

NGINX sangat efektif sebagai reverse proxy dan load balancer. Kemampuannya untuk mendistribusikan lalu lintas ke berbagai server backend membuatnya ideal untuk arsitektur microservices dan aplikasi terdistribusi. Fitur caching yang canggih memungkinkan NGINX untuk menyimpan konten statis dan dinamis, mengurangi beban pada server backend dan mempercepat respons ke client.

Konfigurasi NGINX dikenal dengan sintaksisnya yang deklaratif dan modular. Administrator dapat dengan mudah mengatur berbagai aspek server seperti virtual hosts, SSL/TLS, URL rewriting, dan logging. NGINX juga mendukung berbagai modul tambahan yang memperluas fungsionalitasnya, termasuk modul untuk pemrosesan PHP, streaming media, dan WebSocket.

### 2.7 PHP
PHP (PHP: Hypertext Preprocessor) adalah bahasa pemrograman server-side yang khusus dirancang untuk pengembangan web. Diciptakan oleh Rasmus Lerdorf pada tahun 1994, PHP telah berkembang menjadi salah satu bahasa pemrograman web paling populer dengan ekosistem yang matang dan komunitas yang besar.

Sebagai bahasa server-side, PHP dieksekusi di server web dan menghasilkan HTML yang dikirim ke browser client. PHP memiliki sintaks yang mudah dipelajari, terutama bagi pengembang yang familiar dengan bahasa C dan Java. Bahasa ini mendukung berbagai paradigma pemrograman, termasuk prosedural, object-oriented, dan functional programming.

PHP memiliki integrasi database yang kuat dengan berbagai sistem manajemen basis data, terutama MySQL/MariaDB. Ekstensi PDO (PHP Data Objects) menyediakan interface yang konsisten untuk mengakses berbagai jenis database. PHP juga dilengkapi dengan berbagai ekstensi built-in untuk menangani XML, JSON, file system, network programming, dan image processing.

Ekosistem PHP sangat kaya dengan framework dan library yang memudahkan pengembangan aplikasi modern. Composer, package manager untuk PHP, memungkinkan pengembang untuk mengelola dependensi proyek dengan efisien. PHP-FPM (FastCGI Process Manager) meningkatkan performa PHP dengan mengelola worker processes untuk menangani request.

### 2.8 Browser
Browser web adalah aplikasi perangkat lunak yang memungkinkan pengguna untuk mengakses, menjelajahi, dan berinteraksi dengan konten di World Wide Web. Modern browser seperti Chrome, Firefox, Safari, dan Edge adalah aplikasi kompleks yang menggabungkan berbagai teknologi untuk memberikan pengalaman web yang kaya dan aman.

Komponen utama browser adalah rendering engine yang menerjemahkan HTML, CSS, dan JavaScript menjadi tampilan visual yang interaktif. Setiap browser utama memiliki engine mereka sendiri - Chrome menggunakan Blink, Firefox menggunakan Gecko, dan Safari menggunakan WebKit. Engine ini bertanggung jawab untuk parsing HTML, applying CSS styles, dan executing JavaScript.

JavaScript engine dalam browser memungkinkan eksekusi kode JavaScript yang membuat halaman web menjadi dinamis dan interaktif. V8 (Chrome), SpiderMonkey (Firefox), dan JavaScriptCore (Safari) adalah contoh JavaScript engine modern yang menggunakan teknik kompilasi just-in-time (JIT) untuk mengoptimalkan performa eksekusi kode.

Browser modern juga menyediakan berbagai API web yang powerful untuk pengembangan aplikasi web canggih. Ini termasuk WebSocket untuk komunikasi real-time, WebGL untuk grafis 3D, Web Storage untuk penyimpanan data lokal, dan Service Workers untuk fungsionalitas offline. Fitur keamanan seperti Same-Origin Policy dan Content Security Policy melindungi pengguna dari berbagai ancaman web.

### 2.9 Internet
Internet adalah jaringan global yang menghubungkan miliaran perangkat komputer di seluruh dunia. Dikembangkan awalnya sebagai proyek ARPANET oleh Departemen Pertahanan Amerika Serikat, internet telah berkembang menjadi infrastruktur komunikasi yang fundamental bagi masyarakat modern. Sistem ini beroperasi menggunakan protokol TCP/IP (Transmission Control Protocol/Internet Protocol) yang memungkinkan komunikasi antar perangkat yang berbeda.

Arsitektur internet dibangun berdasarkan model client-server dan sistem routing yang kompleks. Data ditransmisikan dalam bentuk paket-paket kecil yang dapat mengambil berbagai jalur melalui jaringan untuk mencapai tujuannya. DNS (Domain Name System) berperan penting dalam menerjemahkan nama domain yang mudah diingat menjadi alamat IP yang digunakan oleh komputer untuk berkomunikasi.

Protokol HTTP (Hypertext Transfer Protocol) dan HTTPS (HTTP Secure) adalah fondasi dari World Wide Web, memungkinkan transfer data antara server web dan browser. HTTPS menambahkan lapisan enkripsi menggunakan SSL/TLS untuk mengamankan komunikasi. Protokol lain seperti FTP, SMTP, dan POP3/IMAP mendukung berbagai layanan internet seperti transfer file dan email.

Internet of Things (IoT) dan teknologi cloud computing telah memperluas cakupan internet melampaui komputer tradisional. Perangkat pintar, sensor, dan sistem otomasi sekarang dapat terhubung ke internet, menciptakan ekosistem yang semakin terkoneksi dan kompleks.

### 2.10 Server
Server adalah sistem komputer atau program yang menyediakan layanan kepada komputer atau program lain, yang disebut client, dalam jaringan komputer. Server dapat berupa perangkat keras yang didedikasikan atau software yang berjalan pada komputer umum. Arsitektur server modern dirancang untuk memberikan keandalan, skalabilitas, dan keamanan yang tinggi.

Hardware server biasanya dilengkapi dengan komponen yang dioptimalkan untuk performa dan reliabilitas, seperti prosesor server-grade, ECC RAM, redundant power supply, dan sistem penyimpanan RAID. Virtualisasi memungkinkan satu server fisik untuk menjalankan multiple server virtual, meningkatkan efisiensi penggunaan sumber daya.

Server dapat dikategorikan berdasarkan fungsinya, seperti web server untuk melayani konten web, database server untuk manajemen data, mail server untuk layanan email, dan file server untuk penyimpanan dan berbagi file. Load balancing dan failover clustering digunakan untuk mendistribusikan beban kerja dan menjamin high availability.

Manajemen server modern sering menggunakan pendekatan Infrastructure as Code (IaC) dan container orchestration untuk otomatisasi deployment dan maintenance. Tools seperti Docker dan Kubernetes memungkinkan pengelolaan aplikasi yang kompleks dengan lebih efisien.

### 2.11 Ubuntu
Ubuntu adalah distribusi Linux berbasis Debian yang dikembangkan oleh Canonical Ltd. Dirilis pertama kali pada tahun 2004, Ubuntu telah menjadi salah satu distribusi Linux paling populer karena fokusnya pada kemudahan penggunaan dan aksesibilitas. Nama "Ubuntu" berasal dari filosofi Afrika yang menekankan pada hubungan kemanusiaan.

Ubuntu menggunakan model rilis yang terstruktur dengan versi Long Term Support (LTS) yang dirilis setiap dua tahun dan didukung selama lima tahun. Hal ini membuat Ubuntu menjadi pilihan ideal untuk server dan workstation yang membutuhkan stabilitas jangka panjang. Versi non-LTS dirilis setiap enam bulan untuk pengguna yang menginginkan fitur terbaru.

Sistem package management Ubuntu, yang berbasis APT (Advanced Package Tool), menyederhanakan instalasi dan pembaruan software. Repository Ubuntu yang luas menyediakan ribuan paket software yang telah diuji dan siap digunakan. Snap dan Flatpak menambah fleksibilitas dalam distribusi aplikasi dengan format package yang lebih modern.

Ubuntu Server Edition dirancang khusus untuk penggunaan server dengan fokus pada performa, keamanan, dan skalabilitas. Fitur seperti live patch untuk pembaruan kernel tanpa restart, AppArmor untuk keamanan aplikasi, dan dukungan untuk berbagai platform virtualisasi membuat Ubuntu menjadi pilihan populer untuk deployment server.

### 2.12 SMTP
SMTP (Simple Mail Transfer Protocol) adalah protokol standar internet untuk pengiriman email. Dikembangkan pertama kali pada tahun 1982, SMTP telah menjadi fondasi sistem email modern. Protokol ini mendefinisikan bagaimana pesan email dikirim antara server email dan dari email client ke server.

SMTP bekerja melalui serangkaian perintah text-based antara client dan server. Ketika email dikirim, client SMTP berkomunikasi dengan server SMTP penerima melalui port 25 (untuk koneksi tidak terenkripsi) atau port 587 (untuk koneksi terenkripsi dengan STARTTLS). Proses ini melibatkan verifikasi domain, autentikasi pengirim, dan transfer pesan.

Keamanan SMTP telah ditingkatkan seiring waktu dengan penambahan berbagai ekstensi dan protokol. SMTP-AUTH menyediakan mekanisme autentikasi, STARTTLS menambahkan enkripsi, sedangkan SPF, DKIM, dan DMARC membantu mencegah email spoofing dan spam. Modern SMTP server juga menerapkan berbagai filter dan kebijakan untuk melindungi pengguna dari ancaman email.

Integrasi SMTP dalam aplikasi web memungkinkan pengiriman email otomatis untuk berbagai keperluan seperti verifikasi akun, notifikasi, dan newsletter. Library SMTP tersedia di berbagai bahasa pemrograman, memudahkan pengembang untuk mengimplementasikan fungsi email dalam aplikasi mereka.

### 2.13 DOMPDF
DOMPDF adalah library PHP yang powerful untuk mengkonversi dokumen HTML dan CSS menjadi file PDF. Dikembangkan sebagai proyek open source, DOMPDF memungkinkan pengembang untuk menghasilkan dokumen PDF yang kompleks dengan mempertahankan formatting dan styling dari HTML/CSS. Library ini sangat berguna untuk menghasilkan laporan, faktur, dan dokumen bisnis lainnya secara dinamis.

DOMPDF mendukung sebagian besar fitur CSS 2.1 dan beberapa fitur CSS3, memungkinkan kontrol yang detail atas tampilan dokumen. Library ini dapat menangani berbagai elemen HTML termasuk tabel, gambar, font kustom, header dan footer, serta pagination. DOMPDF juga mendukung penggunaan template HTML yang memudahkan pembuatan dokumen PDF dengan format yang konsisten.

Salah satu keunggulan DOMPDF adalah kemampuannya untuk merender Unicode dengan benar, memungkinkan penggunaan berbagai bahasa dan karakter khusus dalam dokumen PDF. Library ini juga menyediakan opsi konfigurasi yang ekstensif untuk mengontrol proses rendering, seperti ukuran halaman, orientasi, margin, dan resolusi gambar.

Dalam pengembangan aplikasi web modern, DOMPDF sering diintegrasikan dengan framework PHP seperti Laravel melalui wrapper package yang menyederhanakan penggunaannya. Library ini mendukung streaming PDF langsung ke browser atau penyimpanan ke file system, memberikan fleksibilitas dalam penanganan output PDF.

### 2.14 Cloudflare
Cloudflare adalah platform keamanan dan performa web global yang menyediakan layanan CDN (Content Delivery Network), DDoS protection, DNS management, dan berbagai fitur keamanan web. Didirikan pada tahun 2009, Cloudflare telah berkembang menjadi salah satu penyedia layanan infrastruktur internet terbesar dengan jaringan data center yang tersebar di seluruh dunia.

CDN Cloudflare bekerja dengan menyimpan salinan konten statis website di server-server yang tersebar secara geografis (edge servers). Ketika pengunjung mengakses website, konten disampaikan dari edge server terdekat, mengurangi latency dan meningkatkan kecepatan loading. Sistem caching pintar Cloudflare juga membantu mengurangi beban pada origin server.

Layanan keamanan Cloudflare mencakup proteksi DDoS yang canggih, Web Application Firewall (WAF), dan SSL/TLS encryption. Platform ini secara otomatis mengidentifikasi dan memblokir berbagai jenis ancaman cyber, termasuk bot jahat, upaya serangan, dan traffic mencurigakan. Fitur seperti Rate Limiting dan Challenge Passage membantu melindungi website dari abuse dan serangan brute force.

Cloudflare juga menyediakan layanan DNS yang cepat dan aman, dengan waktu propagasi yang singkat dan proteksi terhadap DNS-based attacks. Fitur-fitur tambahan seperti Argo Smart Routing, Workers (serverless computing), dan Page Rules memberikan kontrol granular atas routing traffic dan behavior aplikasi web.

### 2.15 SSL/TLS
SSL (Secure Sockets Layer) dan penggantinya TLS (Transport Layer Security) adalah protokol kriptografi yang menjadi standar keamanan untuk komunikasi di internet. Protokol ini menyediakan enkripsi end-to-end untuk melindungi data yang ditransmisikan antara client dan server, mencegah intersepsi dan manipulasi data oleh pihak ketiga.

Proses handshake SSL/TLS melibatkan serangkaian langkah untuk memverifikasi identitas server dan menetapkan parameter enkripsi. Sertifikat digital, yang dikeluarkan oleh Certificate Authority (CA) terpercaya, digunakan untuk membuktikan identitas server dan memfasilitasi pertukaran kunci enkripsi. Modern TLS menggunakan algoritma kriptografi yang kuat seperti AES untuk enkripsi data dan SHA-256 untuk hashing.

SSL/TLS tidak hanya menyediakan enkripsi, tetapi juga menjamin integritas data dan autentikasi server. Forward secrecy, fitur yang diimplementasikan dalam versi TLS modern, memastikan bahwa data historis tetap aman bahkan jika kunci privat server terkompromi di masa depan. Protokol ini juga mendukung berbagai cipher suite yang memungkinkan negosiasi algoritma enkripsi optimal antara client dan server.

Implementasi SSL/TLS telah menjadi standar keamanan wajib untuk website modern, terutama yang menangani data sensitif seperti informasi login dan transaksi finansial. Browser modern menandai website tanpa HTTPS sebagai "tidak aman", mendorong adopsi universal protokol ini. Otomatisasi proses penerbitan dan pembaruan sertifikat melalui layanan seperti Let's Encrypt telah membantu memperluas penggunaan SSL/TLS di seluruh web.
