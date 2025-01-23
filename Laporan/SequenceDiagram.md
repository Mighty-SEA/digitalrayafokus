sequenceDiagram
    autonumber
    actor User as 👤 User
    participant UI as 🖥️ Filament UI
    participant IR as 📋 InvoiceResource
    participant Invoice as 📄 Invoice Model
    participant Calc as 🧮 CalculationService
    participant PDF as 📎 PDF Generator
    participant Email as ✉️ Mail Service

    %% Create Invoice Flow
    rect rgb(240, 248, 255)
        Note over User,Email: Alur Pembuatan Invoice
        User->>+UI: Buat Invoice Baru
        UI->>+IR: CreateInvoice
        IR->>+Invoice: create(invoice_data)
        Invoice-->>-IR: return invoice
        IR-->>-UI: show success notification
        UI-->>-User: Tampilkan Invoice
    end

    %% Currency Conversion Flow
    rect rgb(230, 230, 250)
        Note over User,Email: Alur Konversi Mata Uang
        User->>+UI: Input Harga (IDR/USD)
        UI->>+IR: calculatePrices()
        IR->>+Calc: convertCurrency()
        Note right of Calc: Konversi berdasarkan current_dollar
        alt Konversi dari IDR
            Calc-->>IR: price_dollar = price_rupiah / current_dollar
        else Konversi dari USD
            Calc-->>IR: price_rupiah = price_dollar * current_dollar
        end
        IR->>+Calc: calculateAmounts()
        Calc-->>-IR: return amounts
        IR-->>-UI: Update form values
        UI-->>-User: Tampilkan Hasil Konversi
    end

    %% Generate PDF Flow
    rect rgb(255, 245, 238)
        Note over User,Email: Alur Generate PDF
        User->>+UI: Generate PDF
        UI->>+IR: GeneratePdfAction
        IR->>+PDF: loadView('invoices.pdf')
        PDF->>+Invoice: get invoice data
        Invoice-->>-PDF: return complete data
        PDF-->>-IR: return PDF stream
        IR-->>-UI: download PDF
        UI-->>-User: Save PDF File
    end

    %% Send Invoice Flow
    rect rgb(240, 255, 240)
        Note over User,Email: Alur Pengiriman Invoice
        User->>+UI: Kirim Invoice
        UI->>+IR: SendInvoiceAction
        IR->>+PDF: generate PDF
        PDF-->>-IR: PDF file
        IR->>+Email: send(InvoiceMail)
        Email->>+Invoice: get invoice data
        Invoice-->>-Email: complete data
        Email-->>-IR: email sent
        IR-->>-UI: show success notification
        UI-->>-User: Konfirmasi Pengiriman
    end

    %% Update Status Flow
    rect rgb(255, 250, 240)
        Note over User,Email: Alur Update Status
        User->>+UI: Update Status
        UI->>+IR: updateStatus
        IR->>+Invoice: update(status)
        Invoice-->>-IR: return updated invoice
        IR-->>-UI: show success notification
        UI-->>-User: Tampilkan Status Baru
    end
