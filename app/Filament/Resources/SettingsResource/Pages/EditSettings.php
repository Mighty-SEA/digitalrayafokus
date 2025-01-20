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
                Section::make('Informasi Perusahaan')
                    ->schema([
                        TextInput::make('company_name')
                            ->label('Nama Perusahaan')
                            ->required(),
                        FileUpload::make('company_logo')
                            ->label('Logo Perusahaan')
                            ->image()
                            ->disk('public')
                            ->directory('settings'),
                        FileUpload::make('company_logo2')
                            ->label('Logo Perusahaan 2')
                            ->image()
                            ->disk('public')
                            ->directory('settings'),
                        FileUpload::make('company_logo3')
                            ->label('Logo Perusahaan 3')
                            ->image()
                            ->disk('public')
                            ->directory('settings'),
                        Textarea::make('company_profile')
                            ->label('Profil Perusahaan')
                            ->rows(4),
                        Textarea::make('company_description')
                            ->label('Deskripsi Perusahaan')
                            ->rows(3),
                        Textarea::make('company_visi')
                            ->label('Visi Perusahaan')
                            ->rows(3),
                        Textarea::make('company_misi')
                            ->label('Misi Perusahaan')
                            ->rows(4),
                    ]),
                
                Section::make('Kontak & Lokasi')
                    ->schema([
                        TextInput::make('company_address')
                            ->label('Alamat'),
                        TextInput::make('company_email')
                            ->label('Email')
                            ->email(),
                        TextInput::make('company_phone')
                            ->label('Telepon'),
                    ]),

                Section::make('SEO & Branding')
                    ->schema([
                        TextInput::make('company_tagline')
                            ->label('Tagline'),
                        Textarea::make('company_keywords')
                            ->label('Keywords SEO')
                            ->rows(2),
                    ]),

                Section::make('Konten Beranda')
                    ->schema([
                        TextInput::make('tc1')
                            ->label('Judul Hero Section'),
                        TextInput::make('dc1')
                            ->label('Deskripsi Hero Section'),
                        FileUpload::make('ic1')
                            ->label('Gambar Hero')
                            ->image()
                            ->disk('public')
                            ->directory('settings'),
                        TextInput::make('tc2')
                            ->label('Judul Section 2'),
                        TextInput::make('dc2')
                            ->label('Deskripsi Section 2'),
                        FileUpload::make('ic2')
                            ->label('Gambar Section 2')
                            ->image()
                            ->disk('public')
                            ->directory('settings'),
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

                Section::make('Menu Navigasi')
                    ->schema([
                        TextInput::make('pt1')
                            ->label('Menu 1'),
                        TextInput::make('pt2')
                            ->label('Menu 2'),
                        TextInput::make('pt3')
                            ->label('Menu 3'),
                        TextInput::make('pt4')
                            ->label('Menu 4'),
                        TextInput::make('pt5')
                            ->label('Menu 5'),
                    ]),
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
