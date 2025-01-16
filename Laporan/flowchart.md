flowchart TD
    Start([Mulai]) --> Login[/Login/]
    Login --> Auth{Autentikasi}
    Auth -->|Gagal| Login
    
    Auth -->|Berhasil| Dashboard[Dashboard]
    Dashboard --> PilihMenu{Pilih Menu}
    
    %% Create Invoice Flow
    PilihMenu -->|Buat Invoice| InputCustomer[Input Data Customer]
    InputCustomer --> InputInvoice[Input Detail Invoice]
    InputInvoice --> InputItem[Input Item]
    InputItem --> PilihCurrency{Pilih Mata Uang}
    
    PilihCurrency -->|IDR| InputIDR[Input Harga IDR]
    PilihCurrency -->|USD| InputUSD[Input Harga USD]
    
    InputIDR --> Konversi[Konversi ke USD]
    InputUSD --> Konversi2[Konversi ke IDR]
    
    Konversi --> HitungTotal[Hitung Total]
    Konversi2 --> HitungTotal
    
    HitungTotal --> TambahItem{Tambah Item?}
    TambahItem -->|Ya| InputItem
    TambahItem -->|Tidak| SimpanInvoice[Simpan Invoice]
    
    %% Process Invoice Flow
    SimpanInvoice --> PilihAksi{Pilih Aksi}
    PilihAksi -->|Generate PDF| GeneratePDF[Generate PDF]
    PilihAksi -->|Kirim Email| KirimEmail[Kirim Email]
    PilihAksi -->|Update Status| UpdateStatus[Update Status]
    
    GeneratePDF --> SimpanPDF[Simpan PDF]
    KirimEmail --> ValidasiEmail{Validasi Email}
    ValidasiEmail -->|Valid| ProsesEmail[Proses Pengiriman]
    ValidasiEmail -->|Invalid| KirimEmail
    
    %% Bulk Actions Flow
    PilihMenu -->|Bulk Actions| PilihInvoice[Pilih Multiple Invoice]
    PilihInvoice --> BulkAksi{Pilih Bulk Aksi}
    BulkAksi -->|Generate PDFs| BulkPDF[Generate Multiple PDF]
    BulkAksi -->|Kirim Emails| BulkEmail[Kirim Multiple Email]
    BulkAksi -->|Update Status| BulkStatus[Update Multiple Status]
    
    BulkPDF --> CreateZip[Buat ZIP File]
    BulkEmail --> ProcessEmails[Proses Batch Email]
    BulkStatus --> UpdateDB[Update Database]
    
    %% Export/Import Flow
    PilihMenu -->|Export Data| ExportData[Export ke Excel]
    PilihMenu -->|Import Data| ImportData[Import dari Excel]
    
    ExportData --> ProcessExport[Proses Export]
    ImportData --> ValidateImport[Validasi Data]
    ValidateImport -->|Valid| ProcessImport[Proses Import]
    ValidateImport -->|Invalid| ShowError[Tampilkan Error]
    
    %% End States
    SimpanPDF --> Notifikasi[Tampilkan Notifikasi]
    ProsesEmail --> Notifikasi
    CreateZip --> Notifikasi
    ProcessEmails --> Notifikasi
    UpdateDB --> Notifikasi
    ProcessExport --> Notifikasi
    ProcessImport --> Notifikasi
    ShowError --> Notifikasi
    
    Notifikasi --> End([Selesai])

    %% Styles
    classDef default fill:#f9f9f9,stroke:#333,stroke-width:2px
    classDef input fill:#e1f5fe,stroke:#01579b,stroke-width:2px
    classDef process fill:#fff3e0,stroke:#e65100,stroke-width:2px
    classDef decision fill:#f3e5f5,stroke:#4a148c,stroke-width:2px
    classDef output fill:#e8f5e9,stroke:#1b5e20,stroke-width:2px
    
    class Start,End default
    class InputCustomer,InputInvoice,InputItem,InputIDR,InputUSD input
    class GeneratePDF,KirimEmail,UpdateStatus,ProcessExport,ProcessImport process
    class Auth,PilihMenu,PilihCurrency,TambahItem,PilihAksi,ValidasiEmail,BulkAksi decision
    class Notifikasi,ShowError output
