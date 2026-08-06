<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ArtistDashboardController;
use App\Http\Controllers\BuyerDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;


Route::get('/', [HomepageController::class, 'index'])->name('home');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Marketplace routes (public)
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/artwork/{artwork}', [MarketplaceController::class, 'show'])->name('marketplace.show');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Artist Dashboard
    Route::get('/artist/dashboard', [ArtistDashboardController::class, 'index'])->name('artist.dashboard')->middleware('artist');

    // Artist Artworks
    Route::prefix('artist/artworks')->name('artist.artworks.')->middleware('artist')->group(function () {
        Route::get('/', [ArtworkController::class, 'index'])->name('index');
        Route::get('/create', [ArtworkController::class, 'create'])->name('create');
        Route::post('/', [ArtworkController::class, 'store'])->name('store');
        Route::get('/{artwork}/edit', [ArtworkController::class, 'edit'])->name('edit');
        Route::put('/{artwork}', [ArtworkController::class, 'update'])->name('update');
    });
    
    Route::delete('/artwork/{artwork}', [ArtworkController::class, 'destroy'])->name('artwork.destroy')->middleware('artist');
    Route::post('/artwork/{artwork}/toggle-status', [ArtworkController::class, 'toggleStatus'])->name('artwork.toggle-status')->middleware('artist');

    // Buyer Dashboard
    Route::get('/buyer/dashboard', [BuyerDashboardController::class, 'index'])->name('buyer.dashboard');

    // Cart routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{artwork}', [CartController::class, 'add'])->name('add');
        Route::post('/update/{item}', [CartController::class, 'update'])->name('update');
        Route::post('/remove/{item}', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'getCount'])->name('count');
    });

    // Order routes
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/create-from-cart', [OrderController::class, 'createFromCart'])->name('create_from_cart');
        Route::post('/buy-now', [OrderController::class, 'buyNow'])->name('buy_now');
        Route::get('/checkout/{order}', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/{order}/confirm', [OrderController::class, 'confirm'])->name('confirm');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{order}/ship', [OrderController::class, 'ship'])->name('ship');
        Route::post('/{order}/deliver', [OrderController::class, 'deliver'])->name('deliver');
        Route::get('/artist/orders', [OrderController::class, 'getArtistOrders'])->name('artist_orders');
    });

    // Checkout redirect
    Route::get('/checkout', function () {
        return redirect()->route('order.index');
    })->name('checkout');

    // Bill Route
    Route::get('/bill', [BillController::class, 'index'])->name('bill.index');

    // Messaging routes
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::post('/send', [MessageController::class, 'send'])->name('send');
        Route::get('/conversations', [MessageController::class, 'getConversations'])->name('conversations');
    });

    // Admin Dashboard
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('show_user');
        Route::post('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('update_user_role');
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('show_order');
        Route::get('/artworks', [AdminController::class, 'artworks'])->name('artworks');
        Route::post('/artworks/{artwork}/toggle', [AdminController::class, 'toggleArtworkStatus'])->name('toggle_artwork');
        Route::post('/artworks/{artwork}/delete', [AdminController::class, 'deleteArtwork'])->name('delete_artwork');
    });

    Route::get('/switch-dashboard/{type}', [AuthController::class, 'switchDashboard'])
        ->name('switch.dashboard');

    // Payment routes (GCash)
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/gcash/process/{order}', [\App\Http\Controllers\PaymentController::class, 'processGCash'])->name('gcash.process');
        Route::get('/gcash/form/{order}', [\App\Http\Controllers\PaymentController::class, 'showGCashForm'])->name('gcash.form');
        Route::post('/gcash/mock', [\App\Http\Controllers\PaymentController::class, 'mockGCashPayment'])->name('gcash.mock');
        Route::post('/gcash/callback', [\App\Http\Controllers\PaymentController::class, 'gcashCallback'])->name('gcash.callback');
        Route::get('/gcash/failed/{order}', [\App\Http\Controllers\PaymentController::class, 'paymentFailed'])->name('gcash.failed');
        Route::get('/status/{order}', [\App\Http\Controllers\PaymentController::class, 'checkPaymentStatus'])->name('status');
    });
});


