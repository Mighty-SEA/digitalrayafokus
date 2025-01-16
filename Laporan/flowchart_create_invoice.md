flowchart TD
    %% Create Invoice Flow
    PilihMenu{Pilih Menu} -->|Buat Invoice| InputCustomer[Input Data Customer]
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