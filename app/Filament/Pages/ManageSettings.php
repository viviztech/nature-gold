<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Store Settings';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.manage-settings';

    public ?array $generalData = [];

    public ?array $paymentData = [];

    public ?array $shippingData = [];

    public ?array $socialData = [];

    public ?array $whatsappData = [];

    public function mount(): void
    {
        $this->generalForm->fill([
            'store_name' => Setting::get('store_name', 'Nature Gold'),
            'store_email' => Setting::get('store_email'),
            'store_phone' => Setting::get('store_phone'),
            'store_whatsapp' => Setting::get('store_whatsapp'),
            'store_address' => Setting::get('store_address'),
            'store_gst' => Setting::get('store_gst'),
        ]);

        $this->paymentForm->fill([
            'razorpay_key' => Setting::get('razorpay_key'),
            'razorpay_secret' => Setting::get('razorpay_secret'),
            'phonepe_merchant_id' => Setting::get('phonepe_merchant_id'),
            'cod_enabled' => Setting::get('cod_enabled', 'true'),
            'cod_charge' => Setting::get('cod_charge', '30'),
        ]);

        $this->shippingForm->fill([
            'default_tax_rate' => Setting::get('default_tax_rate', '5'),
        ]);

        $this->socialForm->fill([
            'facebook_url' => Setting::get('facebook_url'),
            'instagram_url' => Setting::get('instagram_url'),
            'youtube_url' => Setting::get('youtube_url'),
        ]);

        $this->whatsappForm->fill([
            'whatsapp_api_token' => Setting::get('whatsapp_api_token'),
            'whatsapp_phone_id' => Setting::get('whatsapp_phone_id'),
            'whatsapp_business_id' => Setting::get('whatsapp_business_id'),
        ]);
    }

    protected function getForms(): array
    {
        return [
            'generalForm',
            'paymentForm',
            'shippingForm',
            'socialForm',
            'whatsappForm',
        ];
    }

    public function generalForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('store_name')
                    ->label('Store Name')
                    ->required(),
                Forms\Components\TextInput::make('store_email')
                    ->label('Store Email')
                    ->email(),
                Forms\Components\TextInput::make('store_phone')
                    ->label('Store Phone'),
                Forms\Components\TextInput::make('store_whatsapp')
                    ->label('WhatsApp Number')
                    ->placeholder('+919876543210'),
                Forms\Components\Textarea::make('store_address')
                    ->label('Store Address')
                    ->rows(2),
                Forms\Components\TextInput::make('store_gst')
                    ->label('GST Number'),
            ])
            ->statePath('generalData');
    }

    public function paymentForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('razorpay_key')
                    ->label('Razorpay Key ID')
                    ->password()
                    ->revealable(),
                Forms\Components\TextInput::make('razorpay_secret')
                    ->label('Razorpay Key Secret')
                    ->password()
                    ->revealable(),
                Forms\Components\TextInput::make('phonepe_merchant_id')
                    ->label('PhonePe Merchant ID')
                    ->password()
                    ->revealable(),
                Forms\Components\Select::make('cod_enabled')
                    ->label('Cash on Delivery')
                    ->options(['true' => 'Enabled', 'false' => 'Disabled']),
                Forms\Components\TextInput::make('cod_charge')
                    ->label('COD Extra Charge')
                    ->numeric()
                    ->prefix('₹'),
            ])
            ->statePath('paymentData');
    }

    public function shippingForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('default_tax_rate')
                    ->label('Default GST Rate')
                    ->numeric()
                    ->suffix('%'),
            ])
            ->statePath('shippingData');
    }

    public function socialForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('facebook_url')
                    ->label('Facebook Page URL')
                    ->url(),
                Forms\Components\TextInput::make('instagram_url')
                    ->label('Instagram Profile URL')
                    ->url(),
                Forms\Components\TextInput::make('youtube_url')
                    ->label('YouTube Channel URL')
                    ->url(),
            ])
            ->statePath('socialData');
    }

    public function whatsappForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('whatsapp_api_token')
                    ->label('WhatsApp Cloud API Token')
                    ->password()
                    ->revealable(),
                Forms\Components\TextInput::make('whatsapp_phone_id')
                    ->label('WhatsApp Phone Number ID'),
                Forms\Components\TextInput::make('whatsapp_business_id')
                    ->label('WhatsApp Business Account ID'),
            ])
            ->statePath('whatsappData');
    }

    public function saveGeneral(): void
    {
        $data = $this->generalForm->getState();
        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'general');
        }
        Notification::make()->title('General settings saved.')->success()->send();
    }

    public function savePayment(): void
    {
        $data = $this->paymentForm->getState();
        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'payment');
        }
        Notification::make()->title('Payment settings saved.')->success()->send();
    }

    public function saveShipping(): void
    {
        $data = $this->shippingForm->getState();
        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'shipping');
        }
        Notification::make()->title('Shipping settings saved.')->success()->send();
    }

    public function saveSocial(): void
    {
        $data = $this->socialForm->getState();
        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'social');
        }
        Notification::make()->title('Social media settings saved.')->success()->send();
    }

    public function saveWhatsapp(): void
    {
        $data = $this->whatsappForm->getState();
        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'whatsapp');
        }
        Notification::make()->title('WhatsApp settings saved.')->success()->send();
    }
}
