<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\FototecaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BibliotecaController as AdminBibliotecaController;
use App\Http\Controllers\Admin\FototecaController as AdminFototecaController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\WebConfigController;

// ============= PÚBLICAS =============
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');

// Biblioteca (Pública)
Route::prefix('biblioteca')->name('biblioteca.')->group(function () {
    Route::get('/', [BibliotecaController::class, 'index'])->name('dashboard');
    Route::get('/inicio', [BibliotecaController::class, 'index'])->name('inicio');
    Route::get('/libros', [BibliotecaController::class, 'indexLibros'])->name('libros.index');
    Route::get('/revistas', [BibliotecaController::class, 'indexRevistas'])->name('revistas.index');
    Route::get('/editoriales', [BibliotecaController::class, 'indexEditoriales'])->name('editoriales.index');
    Route::get('/autores', [BibliotecaController::class, 'indexAutores'])->name('autores.index');
    Route::get('/especiales', [BibliotecaController::class, 'indexEspeciales'])->name('especiales.index');
    Route::get('/nosotros', [BibliotecaController::class, 'indexAportantes'])->name('aportantes.index');
    Route::get('/search', [BibliotecaController::class, 'search'])->name('search');
    Route::get('/category/{category}', [BibliotecaController::class, 'getBooksByCategory'])->name('category');
    Route::get('/autores/{author}', [BibliotecaController::class, 'showAuthor'])->name('autores.show');
    Route::get('/libros/{book}', [BibliotecaController::class, 'showBook'])->name('libros.show');
    Route::get('/revistas/{book}', [BibliotecaController::class, 'showRevista'])->name('revistas.show');
    Route::get('/editoriales/{publisher}', [BibliotecaController::class, 'showEditorial'])->name('editoriales.show');
});

// Fototeca (Pública)
Route::prefix('fototeca')->name('fototeca.')->group(function () {
    Route::get('/', [FototecaController::class, 'index'])->name('dashboard');
    Route::get('/inicio', [FototecaController::class, 'index'])->name('inicio');
    Route::get('/galeria', [FototecaController::class, 'indexGaleria'])->name('galeria.index');
    Route::get('/fotografos', [FototecaController::class, 'indexFotografos'])->name('fotografos.index');
    Route::get('/especiales', [FototecaController::class, 'indexEspeciales'])->name('especiales.index');
    Route::get('/nosotros', [FototecaController::class, 'indexAportantes'])->name('aportantes.index');
    Route::get('/search', [FototecaController::class, 'search'])->name('search');
    Route::get('/category/{category}', [FototecaController::class, 'getPhotosByCategory'])->name('category');
    Route::get('/fotografos/{photographer}', [FototecaController::class, 'showPhotographer'])->name('fotografos.show');
    Route::get('/galeria/{photo}', [FototecaController::class, 'showPhoto'])->name('galeria.show');
});

// ============= AUTENTICACIÓN =============
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============= PROTEGIDAS (Requieren autenticación) =============
Route::middleware('auth')->group(function () {
    // Admin Panel (Solo Admins)
    Route::middleware('can:access-admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        // Biblioteca Admin
        Route::prefix('biblioteca')->name('biblioteca.')->middleware('module.access:biblioteca')->group(function () {
            Route::get('/', [AdminBibliotecaController::class, 'adminIndex'])->name('index');
            // Libros
            Route::get('/books', [AdminBibliotecaController::class, 'indexBooks'])->name('books');
            Route::get('/books/create', [AdminBibliotecaController::class, 'createBook'])->name('books.create');
            Route::post('/books', [AdminBibliotecaController::class, 'storeBook'])->name('books.store');
            Route::get('/books/{book}/edit', [AdminBibliotecaController::class, 'editBook'])->name('books.edit');
            Route::put('/books/{book}', [AdminBibliotecaController::class, 'updateBook'])->name('books.update');
            Route::delete('/books/{book}', [AdminBibliotecaController::class, 'destroyBook'])->name('books.destroy');

            // Autores
            Route::get('/authors', [AdminBibliotecaController::class, 'indexAuthors'])->name('authors');
            Route::get('/authors/create', [AdminBibliotecaController::class, 'createAuthor'])->name('authors.create');
            Route::post('/authors', [AdminBibliotecaController::class, 'storeAuthor'])->name('authors.store');
            Route::get('/authors/{author}/edit', [AdminBibliotecaController::class, 'editAuthor'])->name('authors.edit');
            Route::put('/authors/{author}', [AdminBibliotecaController::class, 'updateAuthor'])->name('authors.update');
            Route::delete('/authors/{author}', [AdminBibliotecaController::class, 'destroyAuthor'])->name('authors.destroy');

            // Editoriales
            Route::get('/publishers', [AdminBibliotecaController::class, 'indexPublishers'])->name('publishers');
            Route::get('/publishers/create', [AdminBibliotecaController::class, 'createPublisher'])->name('publishers.create');
            Route::post('/publishers', [AdminBibliotecaController::class, 'storePublisher'])->name('publishers.store');
            Route::get('/publishers/{publisher}/edit', [AdminBibliotecaController::class, 'editPublisher'])->name('publishers.edit');
            Route::put('/publishers/{publisher}', [AdminBibliotecaController::class, 'updatePublisher'])->name('publishers.update');
            Route::delete('/publishers/{publisher}', [AdminBibliotecaController::class, 'destroyPublisher'])->name('publishers.destroy');

            // Categorías (incluye subcategorías vía parent_id)
            Route::get('/categories', [AdminBibliotecaController::class, 'indexCategories'])->name('categories');
            Route::get('/categories/create', [AdminBibliotecaController::class, 'createCategory'])->name('categories.create');
            Route::post('/categories', [AdminBibliotecaController::class, 'storeCategory'])->name('categories.store');
            Route::get('/categories/{category}/edit', [AdminBibliotecaController::class, 'editCategory'])->name('categories.edit');
            Route::put('/categories/{category}', [AdminBibliotecaController::class, 'updateCategory'])->name('categories.update');
            Route::delete('/categories/{category}', [AdminBibliotecaController::class, 'destroyCategory'])->name('categories.destroy');

            // Revistas
            Route::get('/magazines', [AdminBibliotecaController::class, 'indexMagazines'])->name('magazines');
            Route::get('/magazines/create', [AdminBibliotecaController::class, 'createMagazine'])->name('magazines.create');
            Route::post('/magazines', [AdminBibliotecaController::class, 'storeMagazine'])->name('magazines.store');
            Route::get('/magazines/{book}/edit', [AdminBibliotecaController::class, 'editMagazine'])->name('magazines.edit');
            Route::put('/magazines/{book}', [AdminBibliotecaController::class, 'updateMagazine'])->name('magazines.update');
            Route::delete('/magazines/{book}', [AdminBibliotecaController::class, 'destroyMagazine'])->name('magazines.destroy');

            // Especiales
            Route::get('/specials', [AdminBibliotecaController::class, 'indexSpecials'])->name('specials');
            Route::post('/specials/{book}/toggle', [AdminBibliotecaController::class, 'toggleSpecial'])->name('specials.toggle');
        });

        // Fototeca Admin
        Route::prefix('fototeca')->name('fototeca.')->middleware('module.access:fototeca')->group(function () {
            Route::get('/', [AdminFototecaController::class, 'adminIndex'])->name('index');
            // Fotografías
            Route::get('/photos', [AdminFototecaController::class, 'indexPhotos'])->name('photos');
            Route::get('/photos/create', [AdminFototecaController::class, 'createPhoto'])->name('photos.create');
            Route::post('/photos', [AdminFototecaController::class, 'storePhoto'])->name('photos.store');
            Route::get('/photos/{photo}/edit', [AdminFototecaController::class, 'editPhoto'])->name('photos.edit');
            Route::put('/photos/{photo}', [AdminFototecaController::class, 'updatePhoto'])->name('photos.update');
            Route::delete('/photos/{photo}', [AdminFototecaController::class, 'destroyPhoto'])->name('photos.destroy');

            // Fotógrafos
            Route::get('/photographers', [AdminFototecaController::class, 'indexPhotographers'])->name('photographers');
            Route::get('/photographers/create', [AdminFototecaController::class, 'createPhotographer'])->name('photographers.create');
            Route::post('/photographers', [AdminFototecaController::class, 'storePhotographer'])->name('photographers.store');
            Route::get('/photographers/{photographer}/edit', [AdminFototecaController::class, 'editPhotographer'])->name('photographers.edit');
            Route::put('/photographers/{photographer}', [AdminFototecaController::class, 'updatePhotographer'])->name('photographers.update');
            Route::delete('/photographers/{photographer}', [AdminFototecaController::class, 'destroyPhotographer'])->name('photographers.destroy');

            // Categorías
            Route::get('/categories', [AdminFototecaController::class, 'indexCategories'])->name('categories');
            Route::get('/categories/create', [AdminFototecaController::class, 'createCategory'])->name('categories.create');
            Route::post('/categories', [AdminFototecaController::class, 'storeCategory'])->name('categories.store');
            Route::get('/categories/{category}/edit', [AdminFototecaController::class, 'editCategory'])->name('categories.edit');
            Route::put('/categories/{category}', [AdminFototecaController::class, 'updateCategory'])->name('categories.update');
            Route::delete('/categories/{category}', [AdminFototecaController::class, 'destroyCategory'])->name('categories.destroy');

            // Especiales
            Route::get('/specials', [AdminFototecaController::class, 'indexSpecials'])->name('specials');
            Route::post('/specials/{photo}/toggle', [AdminFototecaController::class, 'toggleSpecial'])->name('specials.toggle');
        });

        // Configurar Web (solo admin global)
        Route::middleware('can:admin-only')->prefix('web-config')->name('web-config.')->group(function () {
            Route::get('/',         [WebConfigController::class, 'index'])->name('index');
            Route::get('/fondos',   [WebConfigController::class, 'fondos'])->name('fondos');
            Route::get('/contacto', [WebConfigController::class, 'contacto'])->name('contacto');
            Route::post('/{key}',   [WebConfigController::class, 'update'])->name('update');
            Route::delete('/{key}', [WebConfigController::class, 'destroy'])->name('destroy');
            Route::post('/contact/update',    [WebConfigController::class, 'updateContact'])->name('contact.update');
            Route::delete('/contact/{key}',   [WebConfigController::class, 'destroyContact'])->name('contact.destroy');
        });

        // Usuarios Admin (solo admin global)
        Route::middleware('can:admin-only')->prefix('usuarios')->name('usuarios.')->group(function () {
            Route::get('/', [UserAdminController::class, 'index'])->name('index');
            Route::post('/', [UserAdminController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserAdminController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserAdminController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserAdminController::class, 'destroy'])->name('destroy');
            Route::post('/{user}/reset-password', [UserAdminController::class, 'resetPassword'])->name('reset-password');
        });
    });
});
