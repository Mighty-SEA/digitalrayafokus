flowchart TD
    %% Process Invoice Flow
    SimpanInvoice[Simpan Invoice] --> PilihAksi{Pilih Aksi}
    PilihAksi -->|Generate PDF| GeneratePDF[Generate PDF]
    PilihAksi -->|Kirim Email| KirimEmail[Kirim Email]
    PilihAksi -->|Update Status| UpdateStatus[Update Status]
    
    GeneratePDF --> SimpanPDF[Simpan PDF]
    KirimEmail --> ValidasiEmail{Validasi Email}
    ValidasiEmail -->|Valid| ProsesEmail[Proses Pengiriman]
    ValidasiEmail -->|Invalid| KirimEmail 