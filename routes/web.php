<?php

use App\Http\Controllers\Approval\Approval;
use App\Http\Controllers\Bom\BomProductionController;
use App\Http\Controllers\Dashboard\DasboardController;
use App\Http\Controllers\Marketing\MarketingController;
use App\Http\Controllers\Master\MasterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DasboardController::class, 'index'])->name('dashboard');

Route::prefix('/master')
    ->name('master.')
    ->controller(MasterController::class)
    ->group(function() {
        Route::get('/allocation', 'allocation')->name('allocation');
        Route::get('/article', 'article')->name('article');
        Route::get('/buyer', 'buyer')->name('buyer');
        Route::get('/material', 'material')->name('material');
        Route::get('/material-type', 'materialType')->name('material.type');
        Route::get('/satuan', 'satuan')->name('satuan');
        Route::get('/account', 'account')->name('account');
        Route::get('/jenis-bc', 'jenisBc')->name('jenis.bc');
        Route::get('/group', 'group')->name('group');
        Route::get('/procurement', 'procurement')->name('procurement');
        Route::get('/purchase-order', 'purchaseOrder')->name('purchase.order');
        Route::get('/tujuan', 'tujuan')->name('tujuan');
        Route::get('/currency', 'currency')->name('currency');
        Route::get('/pic', 'pic')->name('pic');
        Route::get('/supplier', 'supplier')->name('supplier');
        Route::get('/rak', 'rak')->name('rak');
        Route::get('/warehouse', 'warehouse')->name('warehouse');
        Route::get('/location', 'location')->name('location');
        Route::get('/bom-level', 'bomLevel')->name('bom.level');
    });

Route::prefix('/marketing')
    ->name('marketing.')
    ->controller(MarketingController::class)
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/list', 'list')->name('list');
    });

Route::prefix('/approval')
    ->name('approval.')
    ->controller(Approval::class)
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/list/approved', 'listApproved')->name('list.approved');
        Route::get('/list/rejected', 'listRejected')->name('list.rejected');
    });

Route::prefix('/bill-of-material')
    ->name('bom.')
    ->controller(BomProductionController::class)
    ->group(function() {
        Route::get('/production', 'bomProduction')->name('production');
    });