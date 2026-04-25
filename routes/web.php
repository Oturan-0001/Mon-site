<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ContactController;

use Illuminate\Support\Facades\Route;


Route::get('/', [ProductController::class, 'welcome'])->name('home');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/dashboard', function () {
    // Si c'est l'admin qui se connecte, on l'envoie vers SON index
    if (auth()->user()->admin) {
return redirect()->route('admin.products.index');

}
    // Si c'est un client, on le ramène sur l'accueil
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // SUPPRESSION MULTIPLE
    Route::delete('/products/bulk-delete', [ProductController::class, 'bulkDelete'])
        ->name('products.bulkDelete');

    // PRODUITS
    Route::resource('products', ProductController::class)->except(['show']);

    // CONTACT ADMIN
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

});


Route::post('/contact', [ContactController::class, 'store'])->name('contact.send');

Route::view('/apropos', 'apropos')->name('apropos');
Route::view('/contact', 'contact')->name('contact');
Route::view('/offline', 'offline');
require __DIR__.'/auth.php';
