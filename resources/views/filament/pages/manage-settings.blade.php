<x-filament-panels::page>
    <div class="space-y-6">
        {{-- General Settings --}}
        <x-filament::section>
            <x-slot name="heading">General Settings</x-slot>
            <x-slot name="description">Store name, contact details, and GST information.</x-slot>

            <form wire:submit="saveGeneral">
                {{ $this->generalForm }}

                <div class="mt-4">
                    <x-filament::button type="submit">
                        Save General Settings
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- Payment Settings --}}
        <x-filament::section collapsed>
            <x-slot name="heading">Payment Gateway Settings</x-slot>
            <x-slot name="description">Configure Razorpay, PhonePe, and COD settings.</x-slot>

            <form wire:submit="savePayment">
                {{ $this->paymentForm }}

                <div class="mt-4">
                    <x-filament::button type="submit">
                        Save Payment Settings
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- Shipping & Tax --}}
        <x-filament::section collapsed>
            <x-slot name="heading">Shipping & Tax</x-slot>
            <x-slot name="description">Default tax rates and shipping configuration.</x-slot>

            <form wire:submit="saveShipping">
                {{ $this->shippingForm }}

                <div class="mt-4">
                    <x-filament::button type="submit">
                        Save Shipping Settings
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- Social Media --}}
        <x-filament::section collapsed>
            <x-slot name="heading">Social Media</x-slot>
            <x-slot name="description">Facebook, Instagram, and YouTube links.</x-slot>

            <form wire:submit="saveSocial">
                {{ $this->socialForm }}

                <div class="mt-4">
                    <x-filament::button type="submit">
                        Save Social Settings
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- WhatsApp API --}}
        <x-filament::section collapsed>
            <x-slot name="heading">WhatsApp Business API</x-slot>
            <x-slot name="description">Configure WhatsApp Cloud API for order notifications and dealer communication.</x-slot>

            <form wire:submit="saveWhatsapp">
                {{ $this->whatsappForm }}

                <div class="mt-4">
                    <x-filament::button type="submit">
                        Save WhatsApp Settings
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>
    </div>
</x-filament-panels::page>
