<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeritaPenulisController;
use App\Http\Controllers\KategoriPenulisController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\KomentarController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Profiler\Profile;
use App\Http\Controllers\WebAjaxController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\AdminStaticPagesController;
use App\Http\Controllers\OgImageController;
use App\Http\Controllers\UploadController;


Route::get('/', [WebController::class, 'index'])->name('berita.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', [ProfileController::class, 'profile'])->name('profile.show');
    Route::get('/profile/update', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

});

Route::resource('berita', BeritaController::class);
Route::get('berita', [BeritaController::class, 'index'])->name('berita.show');
Route::get('berita/create', [BeritaController::class, 'create'])->name('berita.create');
Route::post('berita', [BeritaController::class, 'store'])->name('berita.store');
Route::get('berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
Route::put('berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
Route::delete('berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
Route::get('/berita/{slug}', [WebController::class, 'show'])->name('web.show');
Route::post('/berita/{berita}/komentar', [KomentarController::class, 'store'])->name('komentar.store');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('web.kategori');
Route::get('/search/autocomplete', [WebController::class, 'autocomplete'])->name('web.search.autocomplete');
Route::get('/search', [WebController::class, 'search'])->name('web.search');

// Dynamic OG Image: serves Base64 image from DB with proper headers for crawlers
Route::get('/og-image/{id}', [OgImageController::class, 'show'])->name('og.image');

Route::post('/contact/messages', [StaticPageController::class, 'storeContactMessage'])->name('static.contact.messages');

Route::get('/ajax/whats-new', [WebAjaxController::class, 'whatsNew'])->name('ajax.whats-new');

// Summernote image upload (must be logged in)
Route::post('/upload/summernote', [UploadController::class, 'summernoteImage'])->name('upload.summernote')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('user', UserController::class);
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});



Route::middleware(['auth', 'role:admin, penulis'])->prefix('admin')->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::get('berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
});

// Public static pages
Route::get('/terms-of-use', [StaticPageController::class, 'termsOfUse'])->name('static.terms-of-use');
Route::get('/privacy-policy', [StaticPageController::class, 'privacyPolicy'])->name('static.privacy-policy');
Route::get('/contact', [StaticPageController::class, 'contact'])->name('static.contact');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Admin CRUD static pages (type-based)
    Route::get('/static-pages', function () {
        return redirect()->route('admin.static-pages.edit', ['type' => 'terms-of-use']);
    })->name('admin.static-pages.index');

    Route::get('/static-pages/{type}', [AdminStaticPagesController::class, 'edit'])->name('admin.static-pages.edit');
    Route::put('/static-pages/{type}', [AdminStaticPagesController::class, 'update'])->name('admin.static-pages.update');
    Route::post('/static-pages/{type}', [AdminStaticPagesController::class, 'store'])->name('admin.static-pages.store');
    Route::delete('/static-pages/{type}', [AdminStaticPagesController::class, 'destroy'])->name('admin.static-pages.destroy');
});

Route::middleware(['auth', 'role:penulis'])->prefix('penulis')->group(function () {

    Route::get('/dashboard', [PenulisController::class, 'dashboard'])->name('penulis.dashboard');
    Route::get('kategori', [KategoriPenulisController::class,'index'])->name('penulis.kategori.index');
    Route::get('berita/create', [BeritaPenulisController::class, 'create'])->name('penulis.berita.create');
    Route::get('berita', [BeritaPenulisController::class, 'index'])->name('penulis.berita.index');
    Route::post('berita', [BeritaPenulisController::class, 'store'])->name('penulis.berita.store');
    Route::get('berita/{berita}/edit', [BeritaPenulisController::class, 'edit'])->name('penulis.berita.edit');
    Route::put('berita/{berita}', [BeritaPenulisController::class, 'update'])->name('penulis.berita.update');
    Route::delete('berita/{berita}', [BeritaPenulisController::class, 'destroy'])->name('penulis.berita.destroy');
});
  
Route::get('/dashboard', function () {
$user = Auth::user();
if ($user->role === 'admin') {
    return redirect('/admin/dashboard');
} elseif ($user->role === 'penulis') {
    return redirect('/penulis/dashboard');
} else {
    return redirect('/'); 
}
})->middleware(['auth', 'verified'])->name('dashboard');
    

// ============================================================
// FITUR MEMBER (Modular - terpisah dari sistem existing)
// Route prefix: /member
// ============================================================
use App\Http\Controllers\Member\MemberAuthController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\MemberProfileController;
use App\Http\Controllers\Member\BookmarkController;
use App\Http\Controllers\Member\LikeController;
use App\Http\Controllers\Member\HistoryController;
use App\Http\Controllers\Member\CommentController;
use App\Http\Controllers\Member\MemberAjaxController;
use App\Http\Controllers\Member\SubscriptionController;
use App\Http\Controllers\Member\KoranController;
use App\Http\Controllers\Admin\AdminMemberController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminKoranPdfController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSubscriptionPlanController;
use App\Http\Controllers\Admin\AdminPaymentMethodController;
use App\Http\Controllers\Admin\AdminRekananController;
use App\Http\Controllers\Admin\BannerController;

// Auth member (guest member)
Route::prefix('member')->name('member.')->group(function () {
    Route::middleware('guest:member')->group(function () {
        Route::get('/register', [MemberAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [MemberAuthController::class, 'register']);
        Route::get('/login', [MemberAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [MemberAuthController::class, 'login']);
    });

    Route::post('/logout', [MemberAuthController::class, 'logout'])->middleware('auth:member')->name('logout');

    // Area member yang sudah login
    Route::middleware('auth:member')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [MemberProfileController::class, 'edit'])->name('profile');
        Route::post('/profile', [MemberProfileController::class, 'update'])->name('profile.update');

        Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks');
        Route::get('/likes', [LikeController::class, 'index'])->name('likes');
        Route::get('/history', [HistoryController::class, 'index'])->name('history');
        Route::delete('/history/clear', [HistoryController::class, 'clear'])->name('history.clear');

Route::get('/comments', [CommentController::class, 'index'])->name('comments');
        Route::post('/berita/{postId}/comment', [CommentController::class, 'store'])->name('comments.store');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// AJAX toggle bookmark & like (dengan id langsung di URL)
        Route::post('/bookmark/{id}', [MemberAjaxController::class, 'bookmark'])->name('bookmark');
        Route::post('/like/{id}', [MemberAjaxController::class, 'like'])->name('like');
        // Variant lama (body post_id) - tetap dipertahankan untuk kompatibilitas
        Route::post('/bookmark/toggle', [MemberAjaxController::class, 'toggleBookmark'])->name('bookmark.toggle');
        Route::post('/like/toggle', [MemberAjaxController::class, 'toggleLike'])->name('like.toggle');

// ===== Fitur Premium: Langganan & Koran Digital =====
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/{plan}/pay', [SubscriptionController::class, 'pay'])->name('subscriptions.pay');
        Route::post('/subscriptions/{plan}', [SubscriptionController::class, 'store'])->name('subscriptions.store');

        // Koran digital - daftar hanya untuk member aktif (middleware member.active)
        Route::middleware('member.active')->group(function () {
            Route::get('/koran', [KoranController::class, 'index'])->name('koran.index');
            Route::get('/koran/{koran}', [KoranController::class, 'show'])->name('koran.show');
            Route::get('/koran/{koran}/download', [KoranController::class, 'download'])->name('koran.download');
        });
    });
});

// ============================================================
// FITUR ADMIN PREMIUM (Modular - terpisah dari sistem existing)
// ============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/members', [AdminMemberController::class, 'index'])->name('members.index');
    Route::post('/members/{member}/toggle', [AdminMemberController::class, 'toggleStatus'])->name('members.toggle');

    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

    Route::get('/koran', [AdminKoranPdfController::class, 'index'])->name('koran.index');
    Route::get('/koran/create', [AdminKoranPdfController::class, 'create'])->name('koran.create');
    Route::post('/koran', [AdminKoranPdfController::class, 'store'])->name('koran.store');
    Route::delete('/koran/{koran}', [AdminKoranPdfController::class, 'destroy'])->name('koran.destroy');

    Route::get('/subscription-plans', [AdminSubscriptionPlanController::class, 'index'])->name('subscription-plans.index');
    Route::get('/subscription-plans/create', [AdminSubscriptionPlanController::class, 'create'])->name('subscription-plans.create');
    Route::post('/subscription-plans', [AdminSubscriptionPlanController::class, 'store'])->name('subscription-plans.store');
    Route::get('/subscription-plans/{subscriptionPlan}/edit', [AdminSubscriptionPlanController::class, 'edit'])->name('subscription-plans.edit');
    Route::put('/subscription-plans/{subscriptionPlan}', [AdminSubscriptionPlanController::class, 'update'])->name('subscription-plans.update');
    Route::delete('/subscription-plans/{subscriptionPlan}', [AdminSubscriptionPlanController::class, 'destroy'])->name('subscription-plans.destroy');

    Route::get('/payment-methods', [AdminPaymentMethodController::class, 'index'])->name('payment-methods.index');
    Route::get('/payment-methods/create', [AdminPaymentMethodController::class, 'create'])->name('payment-methods.create');
    Route::post('/payment-methods', [AdminPaymentMethodController::class, 'store'])->name('payment-methods.store');
    Route::get('/payment-methods/{paymentMethod}/edit', [AdminPaymentMethodController::class, 'edit'])->name('payment-methods.edit');
    Route::put('/payment-methods/{paymentMethod}', [AdminPaymentMethodController::class, 'update'])->name('payment-methods.update');
    Route::delete('/payment-methods/{paymentMethod}', [AdminPaymentMethodController::class, 'destroy'])->name('payment-methods.destroy');

    Route::get('/rekanans', [AdminRekananController::class, 'index'])->name('rekanans.index');
    Route::get('/rekanans/create', [AdminRekananController::class, 'create'])->name('rekanans.create');
    Route::post('/rekanans', [AdminRekananController::class, 'store'])->name('rekanans.store');
    Route::get('/rekanans/{rekanan}/edit', [AdminRekananController::class, 'edit'])->name('rekanans.edit');
    Route::put('/rekanans/{rekanan}', [AdminRekananController::class, 'update'])->name('rekanans.update');
    Route::delete('/rekanans/{rekanan}', [AdminRekananController::class, 'destroy'])->name('rekanans.destroy');

    Route::resource('banners', BannerController::class)->names('banners');
    Route::patch('/banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
    Route::get('/banners/{banner}/click', [BannerController::class, 'click'])->name('banners.click');

    Route::get('/settings/email', [AdminSettingController::class, 'email'])->name('settings.email');
    Route::post('/settings/email', [AdminSettingController::class, 'emailUpdate'])->name('settings.email.store');
});

Route::get('/banner/{banner}/click', [BannerController::class, 'click'])->name('banner.click');

require __DIR__.'/auth.php';
