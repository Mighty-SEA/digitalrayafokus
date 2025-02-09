<?php

namespace App\Filament\Resources\SettingsResource\Pages;

use App\Filament\Resources\SettingsResource;
use App\Models\Settings;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

class EditSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = SettingsResource::class;
    protected static string $view = 'filament.resources.settings-resource.pages.edit-settings';
    public ?array $data = [];

    public function mount(): void
    {
        $settings = Settings::pluck('value', 'key')->all();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs([
                        Tab::make('Informasi Perusahaan')
                            ->schema([
                                Section::make('Informasi Utama')
                                    ->description('Pengaturan informasi dasar perusahaan')
                                    ->schema([
                                        TextInput::make('company_name')
                                            ->label('Nama Perusahaan')
                                            ->required(),
                                        Textarea::make('company_profile')
                                            ->label('Profil Perusahaan')
                                            ->rows(4),
                                        Textarea::make('company_description')
                                            ->label('Deskripsi Singkat')
                                            ->rows(3),
                                    ])->columns(1),

                                Section::make('Logo & Branding')
                                    ->description('Pengaturan logo dan identitas visual')
                                    ->schema([
                                        FileUpload::make('company_logo')
                                            ->label('Logo Utama')
                                            ->image()
                                            ->disk('public')
                                            ->directory('settings'),
                                        FileUpload::make('company_logo2')
                                            ->label('Logo Alternatif')
                                            ->image()
                                            ->disk('public')
                                            ->directory('settings'),
                                        FileUpload::make('company_logo3')
                                            ->label('Logo Footer')
                                            ->image()
                                            ->disk('public')
                                            ->directory('settings'),
                                    ])->columns(3),

                                Section::make('Visi & Misi')
                                    ->description('Pengaturan visi dan misi perusahaan')
                                    ->schema([
                                        Textarea::make('company_visi')
                                            ->label('Visi')
                                            ->rows(3),
                                        Textarea::make('company_misi')
                                            ->label('Misi')
                                            ->rows(4),
                                    ])->columns(2),
                            ]),

                        Tab::make('Kontak & SEO')
                            ->schema([
                                Section::make('Kontak & Lokasi')
                                    ->description('Informasi kontak dan alamat')
                                    ->schema([
                                        TextInput::make('company_address')
                                            ->label('Alamat'),
                                        TextInput::make('company_email')
                                            ->label('Email')
                                            ->email(),
                                        TextInput::make('company_phone')
                                            ->label('Telepon'),
                                    ])->columns(3),

                                Section::make('SEO & Meta')
                                    ->description('Pengaturan untuk optimasi mesin pencari')
                                    ->schema([
                                        TextInput::make('company_tagline')
                                            ->label('Tagline'),
                                        Textarea::make('company_keywords')
                                            ->label('Keywords SEO')
                                            ->rows(2),
                                    ])->columns(2),
                            ]),

                        Tab::make('Halaman Beranda')
                            ->schema([
                                Section::make('Menu & Navigasi')
                                    ->description('Pengaturan menu navigasi')
                                    ->schema([
                                        TextInput::make('pt1')->label('Menu 1'),
                                        TextInput::make('pt2')->label('Menu 2'), 
                                        TextInput::make('pt3')->label('Menu 3'),
                                        TextInput::make('pt4')->label('Menu 4'),
                                        TextInput::make('pt5')->label('Menu 5'),
                                    ])->columns(5),

                                Section::make('Halaman Beranda')
                                    ->description('Pengaturan konten halaman utama')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            Group::make([
                                                TextInput::make('tc1')
                                                    ->label('Judul Hero'),
                                                TextInput::make('dc1')
                                                    ->label('Deskripsi Hero'),
                                                FileUpload::make('ic1')
                                                    ->label('Gambar Hero')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('settings'),
                                            ]),
                                            Group::make([
                                                TextInput::make('tc2')
                                                    ->label('Judul Section 2'),
                                                TextInput::make('dc2')
                                                    ->label('Deskripsi Section 2'),
                                                FileUpload::make('ic2')
                                                    ->label('Gambar Section 2')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('settings'),
                                            ]),
                                        ]),
                                        Grid::make(2)->schema([
                                            FileUpload::make('ic3')
                                                ->label('Gambar Section 3')
                                                ->image()
                                                ->disk('public')
                                                ->directory('settings'),
                                            FileUpload::make('ic4')
                                                ->label('Gambar Section 4')
                                                ->image()
                                                ->disk('public')
                                                ->directory('settings'),
                                        ]),
                                    ]),
                            ]),

                        Tab::make('Pembayaran')
                            ->schema([
                                Section::make('Informasi Pembayaran')
                                    ->description('Pengaturan rekening pembayaran')
                                    ->schema([
                                        TextInput::make('payment_bank')
                                            ->label('Nama Bank')
                                            ->placeholder('Contoh: BRI'),
                                        TextInput::make('payment_account')
                                            ->label('Nomor Rekening')
                                            ->placeholder('Contoh: 398329283298'),
                                        TextInput::make('payment_name')
                                            ->label('Nama Pemilik'),
                                    ])->columns(3),
                            ]),
                    ])
                    ->activeTab(1)
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            
            // Handle file fields
            $fileFields = ['company_logo', 'company_logo2', 'company_logo3', 'ic1', 'ic2', 'ic3', 'ic4'];
            
            foreach ($data as $key => $value) {
                $type = in_array($key, $fileFields) ? 'image' : 'text';
                
                if ($type === 'image' && $value) {
                    // Jika ada file lama, hapus
                    $oldSetting = Settings::where('key', $key)->first();
                    if ($oldSetting && $oldSetting->value) {
                        Storage::disk('public')->delete($oldSetting->value);
                    }
                }
                
                Settings::set($key, $value, $type);
            }
            
            Notification::make()
                ->title('Pengaturan berhasil disimpan')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal menyimpan pengaturan')
                ->danger()
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->send();
        }
    }
}
