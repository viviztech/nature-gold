<div class="mt-6 pt-6 border-t border-gray-100">
    @if($submitted)
        <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700 flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ __('shop.review_submitted') }}
        </div>
    @elseif($this->hasReviewed)
        <p class="text-sm text-gray-500 italic">{{ __('shop.already_reviewed') }}</p>
    @elseif(!auth()->check())
        <p class="text-sm text-gray-500">
            <a href="{{ route('login') }}" class="text-gold-600 hover:text-gold-700 font-medium">{{ __('shop.login_to_review') }}</a>
        </p>
    @elseif(!$this->canReview)
        <p class="text-sm text-gray-500 italic">{{ __('shop.purchase_to_review') }}</p>
    @else
        <h4 class="font-heading font-bold text-gray-900 mb-4">{{ __('shop.write_review') }}</h4>
        <form wire:submit="submit" class="space-y-4">
            {{-- Star Rating --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('shop.your_rating') }}</label>
                <div class="flex gap-1" x-data>
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                wire:click="$set('rating', {{ $i }})"
                                class="focus:outline-none transition-transform hover:scale-110">
                            <svg class="w-7 h-7 {{ $i <= $rating ? 'text-gold-500 fill-current' : 'text-gray-300 fill-current' }}"
                                 viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </button>
                    @endfor
                </div>
                @error('rating') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Comment --}}
            <div>
                <label for="review-comment" class="block text-sm font-medium text-gray-700 mb-1">{{ __('shop.your_review') }}</label>
                <textarea id="review-comment"
                          wire:model="comment"
                          rows="3"
                          maxlength="1000"
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none resize-none"
                          placeholder="{{ __('shop.your_review') }}"></textarea>
            </div>

            <button type="submit"
                    class="px-6 py-2.5 bg-nature-700 text-white font-semibold rounded-lg hover:bg-nature-800 transition text-sm">
                {{ __('shop.submit_review') }}
            </button>
        </form>
    @endif
</div>
