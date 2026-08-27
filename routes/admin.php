<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderChargeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceChargeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminSupportController;
use App\Http\Controllers\Admin\SignCopyOrderController;
use App\Http\Controllers\Admin\IdCardOrderController;
use App\Http\Controllers\Admin\PassportOrderController;
use App\Http\Controllers\Admin\SimConversionController;
use App\Http\Controllers\Admin\SimNetworkOrderController;
use App\Http\Controllers\Admin\TinOrderController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\ManualRechargeController;
use Illuminate\Support\Facades\Route;

// Admin Routes Group
Route::group(["prefix" => "admin"], function () {
    // Guest routes (no auth required)
    Route::get("/login", [LoginController::class, "showLoginForm"])->name("admin.login");
    Route::post("/login", [LoginController::class, "login"])->name("admin.login.submit");
    
    // Protected admin routes
    Route::group(["middleware" => ["auth:admin"]], function () {
        // Dashboard
        Route::get("/dashboard", [DashboardController::class, "index"])->name("admin.dashboard");

        // Profile Management 
        Route::get("/profile", [ProfileController::class, "edit"])->name("admin.profile.edit");
        Route::post("/profile", [ProfileController::class, "update"])->name("admin.profile.update");

        // Support Ticket Routes
        Route::get("/supports", [AdminSupportController::class, "index"])->name("admin.supports");
        Route::get("/supports/{id}", [AdminSupportController::class, "show"])->name("admin.support-detail");
        Route::post("/supports/{id}/reply", [AdminSupportController::class, "reply"])->name("admin.reply-to-support"); 
        Route::post("/supports/{id}/mark-solved", [AdminSupportController::class, "markSolved"])->name("admin.mark-support-solved");
        Route::post("/supports/{id}/update-status", [AdminSupportController::class, "updateStatus"])->name("admin.update-support-status");
        
        // Sign Copy Order Routes
        Route::get("/sign-copy-orders/download/{filename}", [SignCopyOrderController::class, "downloadPDF"])->name("admin.sign-copy-orders.download")->where("filename", ".*");
        Route::get("/sign-copy-orders", [SignCopyOrderController::class, "index"])->name("admin.sign-copy-orders.index");
        Route::post("/sign-copy-orders/{id}/approve", [SignCopyOrderController::class, "approve"])->name("admin.sign-copy-orders.approve");
        Route::post("/sign-copy-orders/{id}/reject", [SignCopyOrderController::class, "reject"])->name("admin.sign-copy-orders.reject");
        Route::post("/sign-copy-orders/{id}/complete", [SignCopyOrderController::class, "complete"])->name("admin.sign-copy-orders.complete");
        Route::post("/sign-copy-orders/{id}/update-status", [SignCopyOrderController::class, "updateStatus"])->name("admin.sign-copy-orders.update-status");
        Route::post("/sign-copy-orders/{id}/upload-pdf", [SignCopyOrderController::class, "uploadPDF"])->name("admin.sign-copy-orders.upload-pdf");
        
        // ID Card Order Routes
        Route::get("/id-card-orders", [IdCardOrderController::class, "index"])->name("admin.id-card-orders.index");
        Route::get("/id-card-orders/get-orders", [IdCardOrderController::class, "getOrders"])->name("admin.id-card-orders.get-orders");
        Route::post("/id-card-orders/{id}/approve", [IdCardOrderController::class, "approve"])->name("admin.id-card-orders.approve");
        Route::post("/id-card-orders/{id}/reject", [IdCardOrderController::class, "reject"])->name("admin.id-card-orders.reject");
        Route::post("/id-card-orders/{id}/complete", [IdCardOrderController::class, "complete"])->name("admin.id-card-orders.complete");
        Route::post("/id-card-orders/{id}/update-status", [IdCardOrderController::class, "updateStatus"])->name("admin.id-card-orders.update-status");
        Route::post("/id-card-orders/{id}/upload-pdf", [IdCardOrderController::class, "uploadPDF"])->name("admin.id-card-orders.upload-pdf");
        Route::post("/id-card-orders/{id}/save-notes", [IdCardOrderController::class, "saveNotes"])->name("admin.id-card-orders.save-notes");
        Route::get("/id-card-orders/{id}/download-pdf", [IdCardOrderController::class, "downloadPDF"])->name("admin.id-card-orders.download-pdf");
        Route::get("/id-card-orders/export", [IdCardOrderController::class, "export"])->name("admin.id-card-orders.export");
        
        // Passport Order Routes
        Route::get("/passport-orders", [PassportOrderController::class, "index"])->name("admin.passport-orders.index");
        Route::get("/passport-orders/get-orders", [PassportOrderController::class, "getOrders"])->name("admin.passport-orders.get-orders");
        Route::get("/passport-orders/{id}/details", [PassportOrderController::class, "details"])->name("admin.passport-orders.details");
        Route::post("/passport-orders/{id}/update-status", [PassportOrderController::class, "updateStatus"])->name("admin.passport-orders.update-status");
        Route::post("/passport-orders/{id}/upload-pdf", [PassportOrderController::class, "uploadPDF"])->name("admin.passport-orders.upload-pdf");
        Route::post("/passport-orders/{id}/save-note", [PassportOrderController::class, "saveNote"])->name("admin.passport-orders.save-note");
        Route::post("/passport-orders/{id}/save-rejection-reason", [PassportOrderController::class, "saveRejectionReason"])->name("admin.passport-orders.save-rejection-reason");
        Route::get("/passport-orders/{id}/download-pdf", [PassportOrderController::class, "downloadPDF"])->name("admin.passport-orders.download-pdf");
        Route::delete("/passport-orders/{id}", [PassportOrderController::class, "destroy"])->name("admin.passport-orders.destroy");
        Route::get("/passport-orders/export", [PassportOrderController::class, "export"])->name("admin.passport-orders.export");
        
        // SIM Conversion Order Routes
        Route::get("/sim-conversions", [SimConversionController::class, "index"])->name("admin.sim-conversions.index");
        Route::get("/sim-conversions/get-orders", [SimConversionController::class, "getOrders"])->name("admin.sim-conversions.get-orders");
        Route::post("/sim-conversions/{id}/approve", [SimConversionController::class, "approve"])->name("admin.sim-conversions.approve");
        Route::post("/sim-conversions/{id}/reject", [SimConversionController::class, "reject"])->name("admin.sim-conversions.reject");
        Route::post("/sim-conversions/{id}/complete", [SimConversionController::class, "complete"])->name("admin.sim-conversions.complete");
        Route::post("/sim-conversions/{id}/update-status", [SimConversionController::class, "updateStatus"])->name("admin.sim-conversions.update-status");
        Route::post("/sim-conversions/{id}/upload-pdf", [SimConversionController::class, "uploadPDF"])->name("admin.sim-conversions.upload-pdf");
        Route::post("/sim-conversions/{id}/save-note", [SimConversionController::class, "saveNote"])->name("admin.sim-conversions.save-note");
        Route::get("/sim-conversions/{id}/download-pdf", [SimConversionController::class, "downloadPDF"])->name("admin.sim-conversions.download-pdf");
        Route::get("/sim-conversions/export", [SimConversionController::class, "export"])->name("admin.sim-conversions.export");
        
        // SIM Network Order Routes
        Route::get("/sim-network-orders", [SimNetworkOrderController::class, "index"])->name("admin.sim-network-orders.index");
        Route::get("/sim-network-orders/get-orders", [SimNetworkOrderController::class, "getOrders"])->name("admin.sim-network-orders.get-orders");
        Route::get("/sim-network-orders/export", [SimNetworkOrderController::class, "export"])->name("admin.sim-network-orders.export");
        Route::post("/sim-network-orders/{id}/approve", [SimNetworkOrderController::class, "approve"])->name("admin.sim-network-orders.approve");
        Route::post("/sim-network-orders/{id}/reject", [SimNetworkOrderController::class, "reject"])->name("admin.sim-network-orders.reject");
        Route::post("/sim-network-orders/{id}/complete", [SimNetworkOrderController::class, "complete"])->name("admin.sim-network-orders.complete");
        Route::post("/sim-network-orders/{id}/update-status", [SimNetworkOrderController::class, "updateStatus"])->name("admin.sim-network-orders.update-status");
        Route::post("/sim-network-orders/{id}/upload-pdf", [SimNetworkOrderController::class, "uploadPdf"])->name("admin.sim-network-orders.upload-pdf");
        Route::post("/sim-network-orders/{id}/update-note", [SimNetworkOrderController::class, "updateNote"])->name("admin.sim-network-orders.update-note");
        Route::get("/sim-network-orders/{id}/download-pdf", [SimNetworkOrderController::class, "downloadPdf"])->name("admin.sim-network-orders.download-pdf");
        
        // TIN Order Routes
        Route::get("/tin-orders", [TinOrderController::class, "index"])->name("admin.tin-orders.index");
        Route::get("/tin-orders/get-orders", [TinOrderController::class, "getOrders"])->name("admin.tin-orders.get-orders");
        Route::post("/tin-orders/{id}/approve", [TinOrderController::class, "approve"])->name("admin.tin-orders.approve");
        Route::post("/tin-orders/{id}/reject", [TinOrderController::class, "reject"])->name("admin.tin-orders.reject");
        Route::post("/tin-orders/{id}/complete", [TinOrderController::class, "complete"])->name("admin.tin-orders.complete");
        Route::post("/tin-orders/{id}/update-status", [TinOrderController::class, "updateStatus"])->name("admin.tin-orders.update-status");
        Route::post("/tin-orders/{id}/upload-pdf", [TinOrderController::class, "uploadPdf"])->name("admin.tin-orders.upload-pdf");
        Route::post("/tin-orders/{id}/save-note", [TinOrderController::class, "saveNote"])->name("admin.tin-orders.save-note");
        Route::get("/tin-orders/{id}/download-pdf", [TinOrderController::class, "downloadPdf"])->name("admin.tin-orders.download-pdf");
        Route::get("/tin-orders/export", [TinOrderController::class, "export"])->name("admin.tin-orders.export");
        
        // Cost Management Routes
        Route::get("/costs", [CostController::class, "index"])->name("admin.cost.index");
        Route::post("/costs", [CostController::class, "store"])->name("admin.cost.store");
        Route::put("/costs/{id}", [CostController::class, "update"])->name("admin.cost.update");
        Route::delete("/costs/{id}", [CostController::class, "destroy"])->name("admin.cost.destroy");

        // Service charge
        Route::get("/service-charges",          [ServiceChargeController::class, "index"]) ->name("admin.service-charges.index");
        Route::post("/service-charges",         [ServiceChargeController::class, "store"]) ->name("admin.service-charges.store");
        Route::put("/service-charges/{serviceCharge}", [ServiceChargeController::class, "update"])->name("admin.service-charges.update");
        Route::delete("/service-charges/{serviceCharge}/delete", [ServiceChargeController::class, "delete"])->name("admin.service-charges.destroy");

        // Order Charges
        Route::get('order-charges', [OrderChargeController::class, 'index'])->name('admin.order-charges.index');
        Route::put('order-charges/{type}/{id}', [OrderChargeController::class, 'update'])->name('admin.order-charges.update');

        // Settings
        Route::get("/settings", [SettingController::class, "edit"])->name("admin.settings.index");
        Route::put("/settings", [SettingController::class, "update"])->name("admin.settings.update");

        // Promo Codes
        Route::resource("promo-codes", PromoCodeController::class)->names("admin.promo-codes");

        // User Management
        Route::get("/users/update-status/{id}/{status}", [UserController::class, "updateStatus"])->name("admin.users.update-status");
        Route::post("/users/update-balance", [UserController::class, "updateBalance"])->name("admin.users.update-balance");
        Route::resource("users", UserController::class)->names("admin.users");

        // Manual Recharge Management
        Route::get("/manual-recharges", [ManualRechargeController::class, "index"])->name("admin.manual-recharges");
        Route::post("/manual-recharge/store", [ManualRechargeController::class, "store"])->name("admin.manual-recharge.store");
        Route::post("/manual-recharge/approve/{id}", [ManualRechargeController::class, "approve"])->name("admin.manual-recharge.approve");
        Route::post("/manual-recharge/cancel/{id}", [ManualRechargeController::class, "cancel"])->name("admin.manual-recharge.cancel");
        // Gateway Management
        Route::get("/gateways", [DashboardController::class, "gateways"])->name("admin.gateways");
        Route::get("/add-gateway", [DashboardController::class, "add_gateway"])->name("admin.add-gateway");
        Route::post("/add-gateway", [DashboardController::class, "store_gateway"])->name("admin.add-gateway");
        Route::get("/edit-gateway/{id}", [DashboardController::class, "edit_gateway"])->name("admin.edit-gateway");
        Route::post("/edit-gateway/{id}", [DashboardController::class, "update_gateway"])->name("admin.edit-gateway");
        Route::post("/delete-gateway/{id}", [DashboardController::class, "delete_gateway"])->name("admin.delete-gateway");
        Route::get("/toggle-gateway/{id}", [DashboardController::class, "toggle_gateway"])->name("admin.toggle-gateway");

        
        // Logout
        Route::post("/logout", [LoginController::class, "logout"])->name("admin.logout");
    });
});
