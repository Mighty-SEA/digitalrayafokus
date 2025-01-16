flowchart TD
    %% Authentication Flow
    Start([Mulai]) --> Login[/Login/]
    Login --> Auth{Autentikasi}
    Auth -->|Gagal| Login
    Auth -->|Berhasil| Dashboard[Dashboard]
    Dashboard --> PilihMenu{Pilih Menu} 