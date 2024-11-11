<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetMovementController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\CellarController;
use App\Http\Controllers\UserController;
use App\Models\Budget_movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
		
		/* GESTIÓN DE INVENTARIO */
		
        //Compañia
        Route::get('companies/{id}', [CompanyController::class, 'show']);
        Route::put('companies/{id}', [CompanyController::class, 'update']);

        //BUDGET_MOVEMENT
        Route::get('budgets', [BudgetMovementController::class, 'index']);
        Route::post('budgets', [BudgetMovementController::class, 'store']);

        // usuarios
        Route::get('user/{id}', [UserController::class, 'show']);
		Route::put('user/{id}', [UserController::class, 'update']);
		
		// vendedores
		Route::get('cellars', [CellarController::class, 'index']);
		Route::get('cellars/{id}', [CellarController::class, 'show']);
		Route::post('cellars', [CellarController::class, 'store']);
		Route::put('cellars/{id}', [CellarController::class, 'update']);
		Route::post('cellars/{id}', [CellarController::class, 'default']);
		Route::delete('cellars/{id}', [CellarController::class, 'destroy']);

        // productos
        Route::get('products', [ProductController::class, 'index']);
        Route::get('searchProduct', [ProductController::class, 'searchProduct']);
        Route::get('products/{id}', [ProductController::class, 'show']);
        Route::post('products', [ProductController::class, 'store']);
		Route::put('products/{id}', [ProductController::class, 'update']);
        Route::delete('products/{id}', [ProductController::class, 'destroy']);
		
		// transfer
		Route::get('transfers', [TransferController::class, 'index']);
		Route::get('transfers/{id}', [TransferController::class, 'show']);
		Route::post('transfers', [transferController::class, 'store']);

        // mov
        Route::get('movements', [MovementController::class, 'index']);
        Route::get('movements/{id}', [MovementController::class, 'show']);
        Route::post('movements', [MovementController::class, 'store']);
		
		/* PUNTO DE VENTA */
		
		// Proveedores
		Route::get('providers', [ProviderController::class, 'index']);
		Route::get('providers/{id}', [ProviderController::class, 'show']);
		Route::post('providers', [ProviderController::class, 'store']);
		Route::put('providers/{id}', [ProviderController::class, 'update']);
		Route::delete('providers/{id}', [ProviderController::class, 'destroy']);
		
		// INVOICES
		Route::get('invoices', [InvoiceController::class, 'index']);
		Route::get('invoices/{id}', [InvoiceController::class, 'show']);		
		Route::post('invoices', [InvoiceController::class, 'store']);
		
		// CUSTOMER
		Route::get('customers', [CustomerController::class, 'index']);
		Route::get('customers/{id}', [CustomerController::class, 'show']);
		Route::post('customers', [CustomerController::class, 'store']);
		Route::put('customers/{id}', [CustomerController::class, 'update']);
		Route::delete('customers/{id}', [CustomerController::class, 'destroy']);
		
		// SALES
		Route::get('sales', [SaleController::class, 'index']);
		Route::get('sales/{id}', [SaleController::class, 'show']);
		Route::post('sales', [SaleController::class, 'store']);
		Route::get('sales/{id}/pdf', [SaleController::class, 'generatePDF']);

		
		// REFUNDS
		Route::get('refunds', [RefundController::class, 'index']);
		Route::get('refunds/{id}', [RefundController::class, 'show']);
		Route::post('refunds', [RefundController::class, 'store']);
		
		// PAYMENTS
		Route::get('payments', [PaymentController::class, 'index']);
		Route::post('payments', [PaymentController::class, 'store']);
    });

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
