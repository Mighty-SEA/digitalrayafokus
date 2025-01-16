```mermaid
erDiagram
    %% Styling
    %%{init: {'theme': 'neutral', 'themeVariables': { 'primaryColor': '#4C566A', 'lineColor': '#81A1C1'}}}%%

    users ||--o{ invoices : membuat
    users ||--o{ exports : memiliki
    users ||--o{ imports : memiliki
    users ||--o{ notifications : menerima
    customers ||--o{ invoices : memiliki
    invoices ||--o{ items : berisi

    users {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at
        string password
        string remember_token
        timestamp created_at
        timestamp updated_at
    }

    customers {
        bigint id PK
        string nama
        string email
        string phone
        string address
        timestamp created_at
        timestamp updated_at
    }

    invoices {
        bigint id PK
        bigint customer_id FK
        date invoice_date
        date due_date
        string email_reciver
        integer current_dollar
        string status
        timestamp created_at
        timestamp updated_at
    }

    items {
        bigint id PK
        bigint invoice_id FK
        string name
        string description
        boolean is_dollar
        integer quantity
        integer price_rupiah
        integer price_dollar
        integer amount_rupiah
        integer amount_dollar
        timestamp created_at
        timestamp updated_at
    }

    notifications {
        uuid id PK
        string type
        string notifiable_type
        bigint notifiable_id
        text data
        timestamp read_at
        timestamp created_at
        timestamp updated_at
    }

    exports {
        bigint id PK
        bigint user_id FK
        timestamp completed_at
        string file_disk
        string file_name
        string exporter
        integer processed_rows
        integer total_rows
        integer successful_rows
        timestamp created_at
        timestamp updated_at
    }

    imports {
        bigint id PK
        bigint user_id FK
        timestamp completed_at
        string file_name
        string file_path
        string importer
        integer processed_rows
        integer total_rows
        integer successful_rows
        timestamp created_at
        timestamp updated_at
    }
