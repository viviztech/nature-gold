<x-layouts.app title="Become a Dealer">
    <div class="max-w-3xl mx-auto px-4 py-16">
        <div class="text-center mb-10">
            <h1 class="font-heading text-3xl font-bold text-gray-900">{{ __('shop.become_dealer') }}</h1>
            <p class="text-gray-500 mt-2">Join the Nature Gold dealer network and grow your business</p>
            <div class="mt-3 w-16 h-1 bg-gold-500 mx-auto rounded"></div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('dealer.register') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Name *</label>
                        <input type="text" name="business_name" value="{{ old('business_name') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Owner Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">GST Number</label>
                        <input type="text" name="gst_number" value="{{ old('gst_number') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Type *</label>
                        <select name="business_type" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">
                            <option value="">Select type</option>
                            <option value="retail">Retail</option>
                            <option value="wholesale">Wholesale</option>
                            <option value="distributor">Distributor</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">District (Territory) *</label>
                        <select name="territory" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">
                            <option value="">Select district</option>
                            @foreach(\App\Enums\TamilNaduDistrict::cases() as $district)
                                <option value="{{ $district->value }}">{{ $district->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                        <input type="password" name="password" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">
                    </div>
                </div>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Business Address</label>
                    <textarea name="business_address" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none text-sm">{{ old('business_address') }}</textarea>
                </div>
                <div class="mt-8">
                    <button type="submit" class="w-full py-3 bg-gold-500 text-white font-semibold rounded-lg hover:bg-gold-600 transition text-sm">
                        Submit Dealer Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
