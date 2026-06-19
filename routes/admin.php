<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CefrController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\EventRequestController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FileSystemController;
use App\Http\Controllers\Admin\LibraryController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\NetworkController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProtectedFileController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TpiSectionController;
use App\Http\Controllers\Admin\TpiCtaSectionController;
use App\Http\Controllers\Admin\TpiFaqController;
use App\Http\Controllers\Admin\TpiHeroSectionController;
use App\Http\Controllers\Admin\TpiOverviewSectionController;
use App\Http\Controllers\Admin\TpiKeyBenefitsSectionController;
use App\Http\Controllers\Admin\TpiJoinPartnerSectionController;
use App\Http\Controllers\Admin\TpiContactSectionController;
use App\Http\Controllers\Admin\NenLandingSettingController;
use App\Http\Controllers\Admin\NenLandingItemController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserSettingController;


use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'authenticate']);

Route::group(['as' => 'admin.', 'middleware' => ['isAdminStaff']], function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('logs', [LogViewerController::class, 'index'])->name('logs');

    Route::group(['prefix' => 'offers', 'as' => 'offers.'], function () {
        Route::get("/", [OfferController::class, "index"])->middleware('checkPermission:offers.index')->name('index');
        Route::post("/", [OfferController::class, "store"])->middleware('checkPermission:offers.create')->name('store');
        Route::get("/create", [OfferController::class, "create"])->middleware('checkPermission:offers.create')->name('create');
        Route::get("/edit/{slug}", [OfferController::class, "edit"])->middleware('checkPermission:offers.edit')->name('edit');
    });

    Route::group(['prefix' => 'locations', 'as' => 'locations.'], function () {
        Route::get("/", [LocationController::class, "index"])->middleware('checkPermission:locations.index')->name('index');
        Route::post("/", [LocationController::class, "store"])->middleware('checkPermission:locations.create')->name('store');
        Route::get("/create", [LocationController::class, "create"])->middleware('checkPermission:locations.create')->name('create');
        Route::get("/edit/{slug}", [LocationController::class, "edit"])->middleware('checkPermission:locations.edit')->name('edit');
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get("/", [CategoryController::class, "index"])->middleware('checkPermission:categories.index')->name('index');
        Route::post("/", [CategoryController::class, "store"])->middleware('checkPermission:categories.create')->name('store');
        Route::get("/create", [CategoryController::class, "create"])->middleware('checkPermission:categories.create')->name('create');
        Route::get("/edit/{slug}", [CategoryController::class, "edit"])->middleware('checkPermission:categories.edit')->name('edit');
    });

    Route::group(['prefix' => 'countries', 'as' => 'countries.'], function () {
        Route::get("/", [CountryController::class, "index"])->middleware('checkPermission:countries.index')->name('index');
        Route::get("/create", [CountryController::class, "create"])->middleware('checkPermission:countries.create')->name('create');
        Route::post("/", [CountryController::class, "store"])->middleware('checkPermission:countries.create')->name('store');
        Route::get("/{country}/edit", [CountryController::class, "edit"])->middleware('checkPermission:countries.edit')->name('edit');
        Route::put("/{country}", [CountryController::class, "update"])->middleware('checkPermission:countries.edit')->name('update');
        Route::delete("/{country}", [CountryController::class, "destroy"])->middleware('checkPermission:countries.delete')->name('destroy');
        Route::get("/{country}", [CountryController::class, "show"])->middleware('checkPermission:countries.index')->name('show');
    });

    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get("/", [ProductController::class, "index"])->middleware('checkPermission:products.index')->name('index');
        Route::post("/", [ProductController::class, "store"])->middleware('checkPermission:products.create')->name('store');
        Route::post("/import", [ProductController::class, "import"])->middleware('checkPermission:products.create')->name('import');
        Route::get("/create", [ProductController::class, "create"])->middleware('checkPermission:products.create')->name('create');
        Route::get("/{slug}", [ProductController::class, "edit"])->middleware('checkPermission:products.edit')->name('edit');
        Route::get("/delete/{product}", [ProductController::class, "delete"])->middleware('checkPermission:products.delete')->name('delete');
    });

    Route::group(['prefix' => 'events', 'as' => 'events.'], function () {
        Route::get("/", [EventController::class, "index"])->name('index');
        Route::post("/", [EventController::class, "store"])->middleware('checkPermission:events.create')->name('store');
        Route::get("/create", [EventController::class, "create"])->middleware('checkPermission:events.create')->name('create');
        Route::get("/edit/{slug}", [EventController::class, "edit"])->name('edit');
    });

    Route::group(['prefix' => 'faqs', 'as' => 'faqs.'], function () {
        Route::get("/", [FaqController::class, "index"])->middleware('checkPermission:faqs.index')->name('index');
        Route::post("/", [FaqController::class, "store"])->middleware('checkPermission:faqs.create')->name('store');
        Route::get("/create", [FaqController::class, "create"])->middleware('checkPermission:faqs.create')->name('create');
        Route::get("/edit/{slug}", [FaqController::class, "edit"])->middleware('checkPermission:faqs.edit')->name('edit');
        Route::delete("/{id}", [FaqController::class, "destroy"])->middleware('checkPermission:faqs.delete')->name('delete');
    });

    Route::group(['prefix' => 'blogs', 'as' => 'blogs.'], function () {
        Route::get("/", [BlogController::class, "index"])->middleware('checkPermission:blogs.index')->name('index');
        Route::post("/", [BlogController::class, "store"])->middleware('checkPermission:blogs.create')->name('store');
        Route::get("/create", [BlogController::class, "create"])->middleware('checkPermission:blogs.create')->name('create');
        Route::get("/edit/{slug}", [BlogController::class, "edit"])->middleware('checkPermission:blogs.edit')->name('edit');
        Route::get("/delete/{id}", [BlogController::class, "destroy"])->middleware('checkPermission:blogs.delete')->name('delete');
    });

    Route::group(['prefix' => 'cefr', 'as' => 'cefr.'], function () {
        Route::get("/", [CefrController::class, "index"])->middleware('checkPermission:cefr.index')->name('index');
        Route::post("/", [CefrController::class, "store"])->middleware('checkPermission:cefr.create')->name('store');
        Route::get("/create", [CefrController::class, "create"])->middleware('checkPermission:cefr.create')->name('create');
        Route::get("/edit/{id}", [CefrController::class, "edit"])->middleware('checkPermission:cefr.edit')->name('edit');
        Route::delete("/{id}", [CefrController::class, "destroy"])->middleware('checkPermission:cefr.edit')->name('destroy');
    });

    Route::group(['prefix' => 'sliders', 'as' => 'sliders.'], function () {
        Route::get("/", [SliderController::class, "index"])->middleware('checkPermission:sliders.index')->name('index');
        Route::post("/", [SliderController::class, "store"])->middleware('checkPermission:sliders.create')->name('store');
        Route::get("/create", [SliderController::class, "create"])->middleware('checkPermission:sliders.create')->name('create');
        Route::get("/edit/{slug}", [SliderController::class, "edit"])->middleware('checkPermission:sliders.edit')->name('edit');
    });

    Route::group(['prefix' => 'partners', 'as' => 'partners.'], function () {
        Route::get("/", [PartnerController::class, "index"])->middleware('checkPermission:partners.index')->name('index');
        Route::post("/", [PartnerController::class, "store"])->middleware('checkPermission:partners.create')->name('store');
        Route::get("/create", [PartnerController::class, "create"])->middleware('checkPermission:partners.create')->name('create');
        Route::get("/edit/{slug}", [PartnerController::class, "edit"])->middleware('checkPermission:partners.edit')->name('edit');
    });

    Route::group(['prefix' => 'network', 'as' => 'network.'], function () {
        Route::get("/", [NetworkController::class, "index"])->middleware('checkPermission:network.index')->name('index');
        Route::post("/", [NetworkController::class, "store"])->middleware('checkPermission:network.create')->name('store');
        Route::get("/create", [NetworkController::class, "create"])->middleware('checkPermission:network.create')->name('create');
        Route::get("/import", [NetworkController::class, "import"])->middleware('checkPermission:network.create')->name('import');
        Route::post("/import", [NetworkController::class, "postImport"])->middleware('checkPermission:network.create');
        Route::get("/edit/{slug}", [NetworkController::class, "edit"])->middleware('checkPermission:network.edit')->name('edit');
    });

    Route::group(['prefix' => 'sections', 'as' => 'sections.'], function () {
        Route::get("/", [SectionController::class, "index"])->middleware('checkPermission:sections.index')->name('index');
        Route::post("/{slug}", [SectionController::class, "update"])->middleware('checkPermission:sections.edit')->name('update');
        Route::get("/edit/{slug}", [SectionController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
    });

    Route::group(['prefix' => 'tpi-section', 'as' => 'tpi-section.'], function () {
        Route::get("/", [TpiSectionController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
        Route::post("/", [TpiSectionController::class, "update"])->middleware('checkPermission:sections.edit')->name('update');
    });

    Route::group(['prefix' => 'tpi-hero-section', 'as' => 'tpi-hero-section.'], function () {
        Route::get("/", [TpiHeroSectionController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
        Route::post("/", [TpiHeroSectionController::class, "update"])->middleware('checkPermission:sections.edit')->name('update');
    });

    Route::group(['prefix' => 'tpi-overview-section', 'as' => 'tpi-overview-section.'], function () {
        Route::get("/", [TpiOverviewSectionController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
        Route::post("/", [TpiOverviewSectionController::class, "update"])->middleware('checkPermission:sections.edit')->name('update');
    });

    Route::group(['prefix' => 'tpi-key-benefits-section', 'as' => 'tpi-key-benefits-section.'], function () {
        Route::get("/", [TpiKeyBenefitsSectionController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
        Route::post("/", [TpiKeyBenefitsSectionController::class, "update"])->middleware('checkPermission:sections.edit')->name('update');
    });

    Route::group(['prefix' => 'tpi-join-partner-section', 'as' => 'tpi-join-partner-section.'], function () {
        Route::get("/", [TpiJoinPartnerSectionController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
        Route::post("/", [TpiJoinPartnerSectionController::class, "update"])->middleware('checkPermission:sections.edit')->name('update');
    });

    Route::group(['prefix' => 'tpi-contact-section', 'as' => 'tpi-contact-section.'], function () {
        Route::get("/", [TpiContactSectionController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
        Route::post("/", [TpiContactSectionController::class, "update"])->middleware('checkPermission:sections.edit')->name('update');
    });

    Route::group(['prefix' => 'tpi-cta-section', 'as' => 'tpi-cta-section.'], function () {
        Route::get("/", [TpiCtaSectionController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
        Route::post("/", [TpiCtaSectionController::class, "update"])->middleware('checkPermission:sections.edit')->name('update');
    });

    Route::group(['prefix' => 'tpi-faqs', 'as' => 'tpi-faqs.'], function () {
        Route::get("/", [TpiFaqController::class, "index"])->middleware('checkPermission:faqs.index')->name('index');
        Route::get("/create", [TpiFaqController::class, "create"])->middleware('checkPermission:faqs.create')->name('create');
        Route::post("/", [TpiFaqController::class, "store"])->middleware('checkPermission:faqs.create')->name('store');
        Route::get("/edit/{id}", [TpiFaqController::class, "edit"])->middleware('checkPermission:faqs.edit')->name('edit');
        Route::delete("/{id}", [TpiFaqController::class, "destroy"])->middleware('checkPermission:faqs.delete')->name('destroy');
    });

    Route::group(['prefix' => 'nen-landing-settings', 'as' => 'nen-landing-settings.'], function () {
        Route::get("/", [NenLandingSettingController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
        Route::post("/", [NenLandingSettingController::class, "update"])->middleware('checkPermission:sections.edit')->name('update');
    });

    Route::group(['prefix' => 'nen-landing-items/{resource}', 'as' => 'nen-landing-items.'], function () {
        Route::get("/", [NenLandingItemController::class, "index"])->middleware('checkPermission:sections.index')->name('index');
        Route::get("/create", [NenLandingItemController::class, "create"])->middleware('checkPermission:sections.create')->name('create');
        Route::post("/", [NenLandingItemController::class, "store"])->middleware('checkPermission:sections.create')->name('store');
        Route::get("/edit/{id}", [NenLandingItemController::class, "edit"])->middleware('checkPermission:sections.edit')->name('edit');
        Route::delete("/{id}", [NenLandingItemController::class, "destroy"])->middleware('checkPermission:sections.delete')->name('destroy');
    });

    Route::group(['prefix' => 'library', 'as' => 'library.'], function () {
        Route::get("/", [LibraryController::class, "index"])->middleware('checkPermission:library.index')->name('index');
        Route::post("/", [LibraryController::class, "store"])->middleware('checkPermission:library.create')->name('store');
        Route::get("/create", [LibraryController::class, "create"])->middleware('checkPermission:library.create')->name('create');
        Route::get("/edit/{slug}", [LibraryController::class, "edit"])->middleware('checkPermission:library.edit')->name('edit');
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.',], function () {
        Route::get("/", [SettingController::class, "index"])->middleware('checkPermission:settings.view')->name('index');
        Route::post("/update", [SettingController::class, "update"])->middleware('checkPermission:settings.update')->name('update');
    });


    Route::prefix("user_settings")->name("user_settings.")->group(function () {
        Route::get("/", [UserSettingController::class, "index"])->middleware('checkPermission:user_settings.view')->name('index');
        Route::post("/update", [UserSettingController::class, "update"])->middleware('checkPermission:user_settings.update')->name('update');
    });


    Route::prefix("histories")->name("histories.")->group(function () {
        Route::get("/", [HistoryController::class, "index"])->middleware('checkPermission:histories.index')->name('index');
    });

    Route::prefix("contact-messages")->name("contact-messages.")->group(function () {
        Route::get("/", [ContactMessageController::class, "index"])->middleware('checkPermission:contacts.index')->name('index');
        Route::get("/mark-done/{contactMessage}", [ContactMessageController::class, "markDone"])->middleware('checkPermission:contacts.manage')->name('mark-done');
        Route::get("/delete/{contactMessage}", [ContactMessageController::class, "delete"])->middleware('checkPermission:contacts.manage')->name('delete');
    });

    Route::prefix("event-requests")->name("event-requests.")->group(function () {
        Route::get("/", [EventRequestController::class, "index"])->middleware('checkPermission:event-requests.index')->name('index');
        Route::get("/mark-done/{eventRequest}", [EventRequestController::class, "markDone"])->middleware('checkPermission:event-requests.manage')->name('mark-done');
        Route::get("/delete/{eventRequest}", [EventRequestController::class, "delete"])->middleware('checkPermission:event-requests.manage')->name('delete');
    });

    Route::prefix("newsletter")->name("newsletter.")->group(function () {
        Route::get("/", [NewsletterController::class, "index"])->middleware('checkPermission:newsletter.index')->name('index');
        Route::get("/export", [NewsletterController::class, "export"])->middleware('checkPermission:newsletter.export')->name('export');
    });


    Route::prefix("users")->name("users.")->group(function () {
        Route::get("/", [UserController::class, "index"])->middleware('checkPermission:users.index')->name('index');
        Route::get("/create", [UserController::class, "create"])->middleware('checkPermission:users.create')->name('create');
        Route::post("/", [UserController::class, "store"])->middleware('checkPermission:users.create')->name('store');
        Route::get("/{id}/edit", [UserController::class, "edit"])->middleware('checkPermission:users.edit')->name('edit');
        Route::post("/{id}/update", [UserController::class, "update"])->middleware('checkPermission:users.edit')->name('update');
        Route::get("/delete/{id}", [UserController::class, "destroy"])->middleware('checkPermission:users.delete')->name('delete');
        Route::get("/{id}/permissions", [UserController::class, "permissions"])->middleware('checkPermission:permissions.edit')->name('permissions');
        Route::post("/update-permissions", [UserController::class, "updatePermissions"])->middleware('checkPermission:permissions.edit')->name('update_permissions');
    });

    Route::prefix("roles")->name("roles.")->group(function () {
        Route::get("/", [RoleController::class, "index"])->middleware('checkPermission:roles.index')->name('index');
        Route::get("/create", [RoleController::class, "create"])->middleware('checkPermission:roles.create')->name('create');
        Route::post("/", [RoleController::class, "store"])->middleware('checkPermission:roles.create')->name('store');
        Route::get("/{id}/edit", [RoleController::class, "edit"])->middleware('checkPermission:roles.edit')->name('edit');
        Route::post("/{id}/update", [RoleController::class, "update"])->middleware('checkPermission:roles.edit')->name('update');
        Route::get("/delete/{id}", [RoleController::class, "destroy"])->middleware('checkPermission:roles.delete')->name('delete');
    });

    Route::prefix("permissions")->name("permissions.")->group(function () {
        Route::get("/", [PermissionController::class, "index"])->middleware('checkPermission:permissions.index')->name('index');
        Route::get("/create", [PermissionController::class, "create"])->middleware('checkPermission:permissions.edit')->name('create');
        Route::post("/", [PermissionController::class, "store"])->middleware('checkPermission:permissions.edit')->name('store');
        Route::get("/{id}/edit", [PermissionController::class, "edit"])->middleware('checkPermission:permissions.edit')->name('edit');
        Route::post("/{id}/update", [PermissionController::class, "update"])->middleware('checkPermission:permissions.edit')->name('update');
        Route::get("/sync-default", [PermissionController::class, "syncDefaultPermissions"])->middleware('checkPermission:permissions.edit')->name('sync-default');
    });

    Route::prefix("notifications")->name("notifications.")->group(function () {
        Route::get("/mark-all-read", [NotificationController::class, "markAllRead"])->middleware('checkPermission:notifications.manage')->name('mark-all-read');
    });

    Route::prefix("file-system")->name("file-system.")->group(function () {
        Route::get("/", [FileSystemController::class, "index"])->middleware('checkPermission:file-system.index')->name('index');
        Route::get("/create", [FileSystemController::class, "create"])->middleware('checkPermission:file-system.create')->name('create');
        Route::post("/", [FileSystemController::class, "store"])->middleware('checkPermission:file-system.create')->name('store');
        Route::get("/preview", [FileSystemController::class, "preview"])->middleware('checkPermission:files.view')->name('preview');
        Route::get("/download", [FileSystemController::class, "download"])->middleware('checkPermission:files.view')->name('download');
        Route::delete("/", [FileSystemController::class, "destroy"])->middleware('checkPermission:files.delete')->name('destroy');
        Route::get("/refresh", [FileSystemController::class, "refresh"])->middleware('checkPermission:files.view')->name('refresh');
        Route::get("/directory-info", [FileSystemController::class, "getDirectoryInfo"])->middleware('checkPermission:files.view')->name('getDirectoryInfo');
    });

    Route::get("/password-change", [GeneralSettingController::class, "changePassword"])->name('update-passwords');
    Route::post("/password-change", [GeneralSettingController::class, "updatePassword"]);

    Route::get("/change_status", [GeneralSettingController::class, "changeStatus"])->name('change_status');
    Route::get("/delete", [GeneralSettingController::class, "delete"])->name('delete');

    Route::prefix("protected-files")->name("protected-files.")->group(function () {
        Route::get("/", [ProtectedFileController::class, "index"])->middleware('checkPermission:protected-files.index')->name('index');
        Route::get("/create", [ProtectedFileController::class, "create"])->middleware('checkPermission:protected-files.create')->name('create');
        Route::post("/", [ProtectedFileController::class, "store"])->middleware('checkPermission:protected-files.create')->name('store');
        Route::get("/{protectedFile}/edit", [ProtectedFileController::class, "edit"])->middleware('checkPermission:protected-files.edit')->name('edit');
        Route::put("/{protectedFile}", [ProtectedFileController::class, "update"])->middleware('checkPermission:protected-files.edit')->name('update');
        Route::delete("/{protectedFile}", [ProtectedFileController::class, "destroy"])->middleware('checkPermission:protected-files.delete')->name('destroy');
        Route::get("/passwords", [ProtectedFileController::class, "passwords"])->middleware('checkPermission:files.view')->name('passwords');
        Route::put("/{protectedFile}/update-password", [ProtectedFileController::class, "updatePassword"])->middleware('checkPermission:files.edit')->name('update-password');
        Route::post("/{protectedFile}/toggle-status", [ProtectedFileController::class, "toggleStatus"])->middleware('checkPermission:files.edit')->name('toggle-status');
    });

    Route::get('logout', function () {
        Auth::logout();
        return redirect('/admin/login')->with('success', 'تم تسجيل الخروج بنجاح');
    })->name('logout');

});
