flowchart TD
    %% Bulk Actions Flow
    PilihMenu{Pilih Menu} -->|Bulk Actions| PilihInvoice[Pilih Multiple Invoice]
    PilihInvoice --> BulkAksi{Pilih Bulk Aksi}
    BulkAksi -->|Generate PDFs| BulkPDF[Generate Multiple PDF]
    BulkAksi -->|Kirim Emails| BulkEmail[Kirim Multiple Email]
    BulkAksi -->|Update Status| BulkStatus[Update Multiple Status]
    
    BulkPDF --> CreateZip[Buat ZIP File]
    BulkEmail --> ProcessEmails[Proses Batch Email]
    BulkStatus --> UpdateDB[Update Database] 