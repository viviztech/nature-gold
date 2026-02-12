<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;
use App\Services\InvoiceService;
use App\Services\ReferralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Display paginated list of user's orders.
     */
    public function orders(): View
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('pages.account.orders', compact('orders'));
    }

    /**
     * Display a single order's details.
     */
    public function orderDetail(Order $order): View
    {
        // Ensure order belongs to the authenticated user
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.product.primaryImage');

        return view('pages.account.order-detail', compact('order'));
    }

    /**
     * Display user's wishlist products.
     */
    public function wishlist(): View
    {
        $wishlistProductIds = Wishlist::where('user_id', auth()->id())
            ->pluck('product_id');

        $wishlistProducts = Product::whereIn('id', $wishlistProductIds)
            ->active()
            ->with(['primaryImage', 'variants', 'category'])
            ->paginate(12);

        return view('pages.account.wishlist', compact('wishlistProducts'));
    }

    /**
     * Display user's saved addresses.
     */
    public function addresses(): View
    {
        $addresses = auth()->user()->addresses()->orderByDesc('is_default')->orderByDesc('created_at')->get();

        return view('pages.account.addresses', compact('addresses'));
    }

    /**
     * Store a new address.
     */
    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'line1' => 'required|string|max:255',
            'line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|size:6',
            'is_default' => 'nullable|boolean',
        ]);

        // If setting as default, unset others
        if (! empty($validated['is_default'])) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'line1' => $validated['line1'],
            'line2' => $validated['line2'] ?? null,
            'city' => $validated['city'],
            'district' => $validated['district'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'is_default' => ! empty($validated['is_default']),
        ]);

        return redirect()->route('account.addresses')->with('success', __('shop.address_saved'));
    }

    /**
     * Delete an address.
     */
    public function destroyAddress(Address $address): RedirectResponse
    {
        abort_unless($address->user_id === auth()->id(), 403);

        $address->delete();

        return redirect()->route('account.addresses')->with('success', __('shop.address_deleted'));
    }

    /**
     * Display profile form.
     */
    public function profile(): View
    {
        return view('pages.account.profile');
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15|unique:users,phone,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('account.profile')->with('success', __('shop.profile_updated'));
    }

    /**
     * Download invoice PDF for an order.
     */
    public function downloadInvoice(Order $order, InvoiceService $invoiceService)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return $invoiceService->download($order);
    }

    /**
     * Display referral program dashboard.
     */
    public function referrals(ReferralService $referralService): View
    {
        $user = auth()->user();
        $stats = $referralService->getUserStats($user);

        return view('pages.account.referrals', [
            'user' => $user,
            'referrals' => $stats['referrals'],
            'totalCount' => $stats['total_count'],
            'totalRewards' => $stats['total_rewards'],
        ]);
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('account.profile')->with('success', __('shop.password_updated'));
    }
}
