<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Excel;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,panitia');
    }

    public function dashboard()
    {
        $orders = Order::latest()->take(10)->get();
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'total_products' => Product::count()
        ];

        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('admin.dashboard', compact('orders', 'stats', 'monthlyOrders'));
    }

    public function banners()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.banners', compact('banners'));
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
            'is_active' => 'boolean'
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'link' => $request->link,
            'is_active' => $request->is_active ?? true,
            'order' => $request->order ?? 0
        ]);

        return back()->with('success', 'Banner ditambahkan!');
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        
        $data = $request->only(['title', 'description', 'link', 'is_active', 'order']);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);
        return back()->with('success', 'Banner diperbarui!');
    }

    public function destroyBanner($id)
    {
        Banner::findOrFail($id)->delete();
        return back()->with('success', 'Banner dihapus!');
    }

    public function users()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $users = User::whereIn('role', ['admin', 'panitia'])->get();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,panitia'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_verified' => true
        ]);

        return back()->with('success', 'User ditambahkan!');
    }

    public function products()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('admin.products', compact('products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required|in:kaos,non-kaos',
            'image' => 'required|image'
        ]);

        $slug = Str::slug($request->name);
        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $path,
            'price' => $request->price,
            'promo_price' => $request->promo_price,
            'type' => $request->type,
            'sizes' => $request->sizes ? json_decode($request->sizes) : null,
            'stock' => $request->stock ?? 0,
            'category_id' => $request->category_id,
            'tags' => $request->tags ? json_decode($request->tags) : null,
            'is_active' => $request->is_active ?? true,
            'is_promo' => $request->is_promo ?? false
        ]);

        return back()->with('success', 'Produk ditambahkan!');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $data = $request->only(['name', 'description', 'price', 'promo_price', 'type', 'stock', 'category_id', 'is_active', 'is_promo']);
        
        if ($request->sizes) {
            $data['sizes'] = json_decode($request->sizes);
        }
        if ($request->tags) {
            $data['tags'] = json_decode($request->tags);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        if ($request->name && $request->name != $product->name) {
            $data['slug'] = Str::slug($request->name);
        }

        $product->update($data);
        return back()->with('success', 'Produk diperbarui!');
    }

    public function destroyProduct($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Produk dihapus!');
    }

    public function orders()
    {
        $orders = Order::with('items', 'user')->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->status]);
        return back()->with('success', 'Status pesanan diperbarui!');
    }

    public function pickUpOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'is_picked_up' => true,
            'picked_up_at' => now(),
            'picked_up_by' => auth()->id(),
            'order_status' => 'completed'
        ]);
        return back()->with('success', 'Pesanan telah diambil!');
    }

    public function verifyPickup($qrCode)
    {
        $order = Order::where('qr_code', $qrCode)->firstOrFail();
        return view('admin.pickup-verify', compact('order'));
    }

    public function vouchers()
    {
        $vouchers = Voucher::all();
        return view('admin.vouchers', compact('vouchers'));
    }

    public function storeVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers',
            'name' => 'required',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric'
        ]);

        Voucher::create($request->all());
        return back()->with('success', 'Voucher ditambahkan!');
    }

    public function destroyVoucher($id)
    {
        Voucher::findOrFail($id)->delete();
        return back()->with('success', 'Voucher dihapus!');
    }

    public function exportReport(Request $request)
    {
        $orders = Order::whereBetween('created_at', [
            $request->start_date ?? now()->subMonth(),
            $request->end_date ?? now()
        ])->with('items')->get();

        if ($request->type === 'pdf') {
            $pdf = PDF::loadView('admin.reports.orders-pdf', compact('orders'));
            return $pdf->download('laporan-pesanan.pdf');
        }

        return Excel::download(new class($orders) implements \Maatwebsite\Excel\Concerns\FromCollection {
            protected $orders;
            public function __construct($orders) { $this->orders = $orders; }
            public function collection() {
                return $this->orders->map(function($order) {
                    return [
                        'No. Pesanan' => $order->order_number,
                        'Nama' => $order->customer_name,
                        'Tipe' => $order->customer_type,
                        'Total' => $order->total,
                        'Status' => $order->order_status,
                        'Tanggal' => $order->created_at->format('d/m/Y')
                    ];
                });
            }
        }, 'laporan-pesanan.xlsx');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id()
        ]);

        $user = auth()->user();
        $data = $request->only(['name', 'email']);
        
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return back()->with('success', 'Pengaturan diperbarui!');
    }
}
