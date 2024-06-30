<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pdf/receipt/{id}', [PdfController::class, 'generateReceipt'])->name('pdf.receipt');

Route::get('/cache', function () {

Artisan::call('optimize:clear');
Artisan::call('config:cache');
Artisan::call('cache:clear');
Artisan::call('view:clear');
Artisan::call('optimize:clear');
//Artisan::call('storage:link');

});

/*
echo $_SERVER['DOCUMENT_ROOT']."<br/>";
$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/storage/app/public';
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/public/storage';
symlink($targetFolder,$linkFolder);
echo 'Symlink completed';
*/
Artisan::call('permissions:sync');
//php artisan permissions:sync
