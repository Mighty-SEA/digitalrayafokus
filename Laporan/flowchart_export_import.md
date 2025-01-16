flowchart TD
    %% Export/Import Flow
    PilihMenu{Pilih Menu} -->|Export Data| ExportData[Export ke Excel]
    PilihMenu -->|Import Data| ImportData[Import dari Excel]
    
    ExportData --> ProcessExport[Proses Export]
    ImportData --> ValidateImport[Validasi Data]
    ValidateImport -->|Valid| ProcessImport[Proses Import]
    ValidateImport -->|Invalid| ShowError[Tampilkan Error]
    
    ProcessExport --> Notifikasi[Tampilkan Notifikasi]
    ProcessImport --> Notifikasi
    ShowError --> Notifikasi
    Notifikasi --> End([Selesai])

    %% Styles
    classDef default fill:#f9f9f9,stroke:#333,stroke-width:2px
    classDef process fill:#fff3e0,stroke:#e65100,stroke-width:2px
    classDef decision fill:#f3e5f5,stroke:#4a148c,stroke-width:2px
    classDef output fill:#e8f5e9,stroke:#1b5e20,stroke-width:2px 