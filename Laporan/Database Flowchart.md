flowchart TD
    %% Style Definitions
    classDef table fill:#eceff1,stroke:#263238,stroke-width:2px
    classDef relation fill:#e3f2fd,stroke:#1565c0,stroke-width:2px
    classDef action fill:#f3e5f5,stroke:#4a148c,stroke-width:2px

    %% User & Auth Tables
    Users[(Users)]
    PasswordReset[(Password Reset)]
    Sessions[(Sessions)]

    %% Main Tables
    Customers[(Customers)]
    Invoices[(Invoices)]
    Items[(Items)]

    %% Support Tables
    Notifications[(Notifications)]
    Exports[(Exports)]
    Imports[(Imports)]

    %% Relationships
    Users --> |1:N| Invoices
    Users --> |1:N| Notifications
    Users --> |1:N| Exports
    Users --> |1:N| Imports
    Users --> |1:1| PasswordReset
    Users --> |1:N| Sessions

    Customers --> |1:N| Invoices
    Invoices --> |1:N| Items

    %% Data Flow Actions
    CreateInvoice[Create Invoice] --> Invoices
    UpdateInvoice[Update Invoice] --> Invoices
    AddItems[Add Items] --> Items
    
    Invoices --> GeneratePDF[Generate PDF]
    Invoices --> SendEmail[Send Email]
    
    ImportData[Import Data] --> Imports
    Exports --> ExportData[Export Data]

    %% Apply Styles
    class Users,Customers,Invoices,Items,Notifications,Exports,Imports,PasswordReset,Sessions table
    class CreateInvoice,UpdateInvoice,AddItems,GeneratePDF,SendEmail,ImportData,ExportData action

    %% Notes
    subgraph Note [Keterangan]
        TableNote[Table/Entity] -..- ActionNote[Action/Process]
        direction LR
    end
