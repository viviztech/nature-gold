<?php

namespace App\Http\Controllers;

use App\Enums\DealerStatus;
use App\Enums\UserRole;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DealerController extends Controller
{
    /**
     * Handle dealer registration form submission.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:8',
            'business_name' => 'required|string|max:255',
            'gst_number' => 'nullable|string|max:15',
            'business_type' => 'required|in:retail,wholesale,distributor',
            'territory' => 'required|string|max:100',
            'business_address' => 'nullable|string|max:500',
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => UserRole::Dealer,
            ]);

            Dealer::create([
                'user_id' => $user->id,
                'business_name' => $validated['business_name'],
                'gst_number' => $validated['gst_number'],
                'business_type' => $validated['business_type'],
                'territory' => $validated['territory'],
                'business_address' => $validated['business_address'],
                'status' => DealerStatus::Pending,
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('dealer.pending')
            ->with('success', __('dealer.registration_success'));
    }

    /**
     * Show pending approval page.
     */
    public function pending()
    {
        $user = auth()->user();

        if (! $user->isDealer()) {
            return redirect()->route('home');
        }

        $dealer = $user->dealer;

        if ($dealer && $dealer->isApproved()) {
            return redirect()->route('dealer.dashboard');
        }

        return view('pages.dealer.pending', compact('dealer'));
    }

    /**
     * Dealer dashboard overview.
     */
    public function dashboard()
    {
        $dealer = auth()->user()->dealer;
        $user = auth()->user();

        $stats = [
            'total_orders' => $user->orders()->where('is_dealer_order', true)->count(),
            'pending_orders' => $user->orders()->where('is_dealer_order', true)->where('status', 'pending')->count(),
            'total_spent' => $user->orders()->where('is_dealer_order', true)->where('payment_status', 'paid')->sum('total'),
        ];

        $recentOrders = $user->orders()
            ->where('is_dealer_order', true)
            ->with('items')
            ->latest()
            ->limit(5)
            ->get();

        return view('pages.dealer.dashboard', compact('dealer', 'stats', 'recentOrders'));
    }

    /**
     * Dealer product catalog with special pricing.
     */
    public function catalog()
    {
        $dealer = auth()->user()->dealer;

        $products = Product::where('is_active', true)
            ->with(['primaryImage', 'variants', 'category'])
            ->paginate(20);

        // Get dealer-specific pricing
        $dealerPricing = $dealer->specialPricing()
            ->pluck('special_price', 'product_id')
            ->toArray();

        $minQuantities = $dealer->specialPricing()
            ->pluck('min_quantity', 'product_id')
            ->toArray();

        return view('pages.dealer.catalog', compact('products', 'dealerPricing', 'minQuantities', 'dealer'));
    }

    /**
     * Dealer order history.
     */
    public function orders()
    {
        $orders = auth()->user()->orders()
            ->where('is_dealer_order', true)
            ->with('items')
            ->latest()
            ->paginate(15);

        return view('pages.dealer.orders', compact('orders'));
    }

    /**
     * Dealer order detail.
     */
    public function orderDetail($order)
    {
        $order = auth()->user()->orders()
            ->where('is_dealer_order', true)
            ->with('items.product.primaryImage')
            ->findOrFail($order);

        return view('pages.dealer.order-detail', compact('order'));
    }

    /**
     * Download dealer invoice.
     */
    public function downloadInvoice($order, InvoiceService $invoiceService)
    {
        $order = auth()->user()->orders()
            ->where('is_dealer_order', true)
            ->findOrFail($order);

        return $invoiceService->download($order);
    }

    /**
     * Dealer profile page.
     */
    public function profile()
    {
        $dealer = auth()->user()->dealer;

        return view('pages.dealer.profile', compact('dealer'));
    }

    /**
     * Update dealer profile.
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_address' => 'nullable|string|max:500',
            'gst_number' => 'nullable|string|max:15',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,phone,' . auth()->id(),
        ]);

        auth()->user()->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
        ]);

        auth()->user()->dealer->update([
            'business_name' => $validated['business_name'],
            'business_address' => $validated['business_address'],
            'gst_number' => $validated['gst_number'],
        ]);

        return redirect()->route('dealer.profile')
            ->with('success', __('dealer.profile_updated'));
    }
}
