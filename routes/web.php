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
    Route::get('/autores', [BibliotecaController::class, 'indexAutores'])->name('autores.index');
    Route::get('/especiales', [BibliotecaController::class, 'indexEspeciales'])->name('especiales.index');
    Route::get('/especiales/{special}', [BibliotecaController::class, 'showEspecial'])->name('especiales.show');
    Route::get('/editorial', [BibliotecaController::class, 'indexEditorial'])->name('editorial.index');
    Route::get('/nosotros', [BibliotecaController::class, 'indexAportantes'])->name('aportantes.index');
    Route::get('/search', [BibliotecaController::class, 'search'])->name('search');
    Route::get('/category/{category}', [BibliotecaController::class, 'getBooksByCategory'])->name('category');
    Route::get('/autores/{author}', [BibliotecaController::class, 'showAuthor'])->name('autores.show');
    Route::get('/libros/{book}', [BibliotecaController::class, 'showBook'])->name('libros.show');
    Route::get('/revistas/{book}', [BibliotecaController::class, 'showRevista'])->name('revistas.show');
});

// Fototeca (Pública)
Route::prefix('fototeca')->name('fototeca.')->group(function () {
    Route::get('/', [FototecaController::class, 'index'])->name('dashboard');
    Route::get('/inicio', [FototecaController::class, 'index'])->name('inicio');
    Route::get('/galeria', [FototecaController::class, 'indexGaleria'])->name('galeria.index');
    Route::get('/fotografos', [FototecaController::class, 'indexFotografos'])->name('fotografos.index');
    Route::get('/nosotros', [FototecaController::class, 'indexAportantes'])->name('aportantes.index');
    Route::get('/search', [FototecaController::class, 'search'])->name('search');
    Route::get('/category/{category}', [FototecaController::class, 'getPhotosByCategory'])->name('category');
    Route::get('/tag/{photoTag}', [FototecaController::class, 'getPhotosByTag'])->name('tag');
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
            Route::delete('/books', [AdminBibliotecaController::class, 'bulkDestroyBooks'])->name('books.bulk-destroy');

            // Autores
            Route::get('/authors', [AdminBibliotecaController::class, 'indexAuthors'])->name('authors');
            Route::get('/authors/create', [AdminBibliotecaController::class, 'createAuthor'])->name('authors.create');
            Route::post('/authors', [AdminBibliotecaController::class, 'storeAuthor'])->name('authors.store');
            Route::get('/authors/{author}/edit', [AdminBibliotecaController::class, 'editAuthor'])->name('authors.edit');
            Route::put('/authors/{author}', [AdminBibliotecaController::class, 'updateAuthor'])->name('authors.update');
            Route::delete('/authors/{author}', [AdminBibliotecaController::class, 'destroyAuthor'])->name('authors.destroy');
            Route::delete('/authors', [AdminBibliotecaController::class, 'bulkDestroyAuthors'])->name('authors.bulk-destroy');

            // Editoriales
            Route::get('/publishers', [AdminBibliotecaController::class, 'indexPublishers'])->name('publishers');
            Route::get('/publishers/create', [AdminBibliotecaController::class, 'createPublisher'])->name('publishers.create');
            Route::post('/publishers', [AdminBibliotecaController::class, 'storePublisher'])->name('publishers.store');
            Route::get('/publishers/{publisher}/edit', [AdminBibliotecaController::class, 'editPublisher'])->name('publishers.edit');
            Route::put('/publishers/{publisher}', [AdminBibliotecaController::class, 'updatePublisher'])->name('publishers.update');
            Route::delete('/publishers/{publisher}', [AdminBibliotecaController::class, 'destroyPublisher'])->name('publishers.destroy');
            Route::delete('/publishers', [AdminBibliotecaController::class, 'bulkDestroyPublishers'])->name('publishers.bulk-destroy');

            // Categorías (incluye subcategorías vía parent_id)
            Route::get('/categories', [AdminBibliotecaController::class, 'indexCategories'])->name('categories');
            Route::get('/categories/create', [AdminBibliotecaController::class, 'createCategory'])->name('categories.create');
            Route::post('/categories', [AdminBibliotecaController::class, 'storeCategory'])->name('categories.store');
            Route::get('/categories/{category}/edit', [AdminBibliotecaController::class, 'editCategory'])->name('categories.edit');
            Route::put('/categories/{category}', [AdminBibliotecaController::class, 'updateCategory'])->name('categories.update');
            Route::delete('/categories/{category}', [AdminBibliotecaController::class, 'destroyCategory'])->name('categories.destroy');
            Route::delete('/categories', [AdminBibliotecaController::class, 'bulkDestroyCategories'])->name('categories.bulk-destroy');

            // Revistas
            Route::get('/magazines', [AdminBibliotecaController::class, 'indexMagazines'])->name('magazines');
            Route::get('/magazines/create', [AdminBibliotecaController::class, 'createMagazine'])->name('magazines.create');
            Route::post('/magazines', [AdminBibliotecaController::class, 'storeMagazine'])->name('magazines.store');
            Route::get('/magazines/{book}/edit', [AdminBibliotecaController::class, 'editMagazine'])->name('magazines.edit');
            Route::put('/magazines/{book}', [AdminBibliotecaController::class, 'updateMagazine'])->name('magazines.update');
            Route::delete('/magazines/{book}', [AdminBibliotecaController::class, 'destroyMagazine'])->name('magazines.destroy');
            Route::delete('/magazines', [AdminBibliotecaController::class, 'bulkDestroyMagazines'])->name('magazines.bulk-destroy');

            // Descriptores
            Route::get('/descriptors', [AdminBibliotecaController::class, 'indexDescriptors'])->name('descriptors');
            Route::post('/descriptors', [AdminBibliotecaController::class, 'storeDescriptor'])->name('descriptors.store');
            Route::put('/descriptors/{descriptor}', [AdminBibliotecaController::class, 'updateDescriptor'])->name('descriptors.update');
            Route::delete('/descriptors/{descriptor}', [AdminBibliotecaController::class, 'destroyDescriptor'])->name('descriptors.destroy');

            // SubCategorías
            Route::get('/subcategories', [AdminBibliotecaController::class, 'indexSubcategories'])->name('subcategories');
            Route::get('/subcategories/create', [AdminBibliotecaController::class, 'createSubcategory'])->name('subcategories.create');
            Route::post('/subcategories', [AdminBibliotecaController::class, 'storeSubcategory'])->name('subcategories.store');
            Route::get('/subcategories/{category}/edit', [AdminBibliotecaController::class, 'editSubcategory'])->name('subcategories.edit');
            Route::put('/subcategories/{category}', [AdminBibliotecaController::class, 'updateSubcategory'])->name('subcategories.update');
            Route::delete('/subcategories/{category}', [AdminBibliotecaController::class, 'destroySubcategory'])->name('subcategories.destroy');
            Route::delete('/subcategories', [AdminBibliotecaController::class, 'bulkDestroySubcategories'])->name('subcategories.bulk-destroy');

            // Especiales (grupos/colecciones)
            Route::get('/specials', [AdminBibliotecaController::class, 'indexSpecials'])->name('specials');
            Route::get('/specials/create', [AdminBibliotecaController::class, 'createSpecial'])->name('specials.create');
            Route::post('/specials', [AdminBibliotecaController::class, 'storeSpecial'])->name('specials.store');
            Route::get('/specials/assign-books', [AdminBibliotecaController::class, 'assignBooksIndex'])->name('specials.assign-books');
            Route::get('/specials/{special}/manage', [AdminBibliotecaController::class, 'manageSpecial'])->name('specials.manage');
            Route::get('/specials/{special}/edit', [AdminBibliotecaController::class, 'editSpecial'])->name('specials.edit');
            Route::put('/specials/{special}', [AdminBibliotecaController::class, 'updateSpecial'])->name('specials.update');
            Route::delete('/specials/{special}', [AdminBibliotecaController::class, 'destroySpecial'])->name('specials.destroy');
            Route::post('/specials/{special}/assign', [AdminBibliotecaController::class, 'assignBook'])->name('specials.assign');
            Route::delete('/specials/{special}/books/{book}', [AdminBibliotecaController::class, 'unassignBook'])->name('specials.unassign');
            Route::delete('/specials/{special}/clear', [AdminBibliotecaController::class, 'clearSpecial'])->name('specials.clear');
            Route::delete('/specials/{special}/cover', [AdminBibliotecaController::class, 'destroySpecialCover'])->name('specials.cover.destroy');
            Route::delete('/specials', [AdminBibliotecaController::class, 'bulkDestroySpecials'])->name('specials.bulk-destroy');
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
            Route::delete('/photos', [AdminFototecaController::class, 'bulkDestroyPhotos'])->name('photos.bulk-destroy');

            // Fotógrafos
            Route::get('/photographers', [AdminFototecaController::class, 'indexPhotographers'])->name('photographers');
            Route::get('/photographers/create', [AdminFototecaController::class, 'createPhotographer'])->name('photographers.create');
            Route::post('/photographers', [AdminFototecaController::class, 'storePhotographer'])->name('photographers.store');
            Route::get('/photographers/{photographer}/edit', [AdminFototecaController::class, 'editPhotographer'])->name('photographers.edit');
            Route::put('/photographers/{photographer}', [AdminFototecaController::class, 'updatePhotographer'])->name('photographers.update');
            Route::delete('/photographers/{photographer}', [AdminFototecaController::class, 'destroyPhotographer'])->name('photographers.destroy');
            Route::delete('/photographers', [AdminFototecaController::class, 'bulkDestroyPhotographers'])->name('photographers.bulk-destroy');

            // Categorías (Nivel 1)
            Route::get('/categories', [AdminFototecaController::class, 'indexCategories'])->name('categories');
            Route::get('/categories/create', [AdminFototecaController::class, 'createCategory'])->name('categories.create');
            Route::post('/categories', [AdminFototecaController::class, 'storeCategory'])->name('categories.store');
            Route::get('/categories/{category}/edit', [AdminFototecaController::class, 'editCategory'])->name('categories.edit');
            Route::put('/categories/{category}', [AdminFototecaController::class, 'updateCategory'])->name('categories.update');
            Route::delete('/categories/{category}', [AdminFototecaController::class, 'destroyCategory'])->name('categories.destroy');
            Route::delete('/categories', [AdminFototecaController::class, 'bulkDestroyCategories'])->name('categories.bulk-destroy');

            // SubCategorías (Nivel 2)
            Route::get('/subcategories', [AdminFototecaController::class, 'indexSubcategories'])->name('subcategories');
            Route::get('/subcategories/create', [AdminFototecaController::class, 'createSubcategory'])->name('subcategories.create');
            Route::post('/subcategories', [AdminFototecaController::class, 'storeSubcategory'])->name('subcategories.store');
            Route::get('/subcategories/{category}/edit', [AdminFototecaController::class, 'editSubcategory'])->name('subcategories.edit');
            Route::put('/subcategories/{category}', [AdminFototecaController::class, 'updateSubcategory'])->name('subcategories.update');
            Route::delete('/subcategories/{category}', [AdminFototecaController::class, 'destroySubcategory'])->name('subcategories.destroy');
            Route::delete('/subcategories', [AdminFototecaController::class, 'bulkDestroySubcategories'])->name('subcategories.bulk-destroy');

            // SubNivel (Nivel 3)
            Route::get('/sublevels', [AdminFototecaController::class, 'indexSublevels'])->name('sublevels');
            Route::get('/sublevels/create', [AdminFototecaController::class, 'createSublevel'])->name('sublevels.create');
            Route::post('/sublevels', [AdminFototecaController::class, 'storeSublevel'])->name('sublevels.store');
            Route::get('/sublevels/{category}/edit', [AdminFototecaController::class, 'editSublevel'])->name('sublevels.edit');
            Route::put('/sublevels/{category}', [AdminFototecaController::class, 'updateSublevel'])->name('sublevels.update');
            Route::delete('/sublevels/{category}', [AdminFototecaController::class, 'destroySublevel'])->name('sublevels.destroy');
            Route::delete('/sublevels', [AdminFototecaController::class, 'bulkDestroySublevels'])->name('sublevels.bulk-destroy');

            // 2do Nivel (Nivel 4)
            Route::get('/secondlevels', [AdminFototecaController::class, 'indexSecondlevels'])->name('secondlevels');
            Route::get('/secondlevels/create', [AdminFototecaController::class, 'createSecondlevel'])->name('secondlevels.create');
            Route::post('/secondlevels', [AdminFototecaController::class, 'storeSecondlevel'])->name('secondlevels.store');
            Route::get('/secondlevels/{category}/edit', [AdminFototecaController::class, 'editSecondlevel'])->name('secondlevels.edit');
            Route::put('/secondlevels/{category}', [AdminFototecaController::class, 'updateSecondlevel'])->name('secondlevels.update');
            Route::delete('/secondlevels/{category}', [AdminFototecaController::class, 'destroySecondlevel'])->name('secondlevels.destroy');
            Route::delete('/secondlevels', [AdminFototecaController::class, 'bulkDestroySecondlevels'])->name('secondlevels.bulk-destroy');

            // Etiquetas
            Route::get('/tags', [AdminFototecaController::class, 'indexTags'])->name('tags');
            Route::post('/tags', [AdminFototecaController::class, 'storeTag'])->name('tags.store');
            Route::put('/tags/{photoTag}', [AdminFototecaController::class, 'updateTag'])->name('tags.update');
            Route::delete('/tags/{photoTag}', [AdminFototecaController::class, 'destroyTag'])->name('tags.destroy');

        });

        // Configurar Web (solo admin global)
        Route::middleware('can:admin-only')->prefix('web-config')->name('web-config.')->group(function () {
            Route::get('/',         [WebConfigController::class, 'index'])->name('index');
            Route::get('/fondos',   [WebConfigController::class, 'fondos'])->name('fondos');
            Route::get('/contacto', [WebConfigController::class, 'contacto'])->name('contacto');
            Route::get('/aportantes',  [WebConfigController::class, 'aportantes'])->name('aportantes');
            Route::post('/aportantes', [WebConfigController::class, 'aportantesUpdate'])->name('aportantes.update');
            Route::post('/contact/update',                  [WebConfigController::class, 'updateContact'])->name('contact.update');
            Route::delete('/contact/{key}',               [WebConfigController::class, 'destroyContact'])->name('contact.destroy');
            Route::post('/floating-btn/{floatingButton}',            [WebConfigController::class, 'updateFloatingButton'])->name('floating-btn.update');
            Route::delete('/floating-btn/{floatingButton}',          [WebConfigController::class, 'destroyFloatingButton'])->name('floating-btn.destroy');
            Route::delete('/floating-btn/{floatingButton}/imagen',   [WebConfigController::class, 'destroyFloatingButtonImagen'])->name('floating-btn.imagen.destroy');
            Route::delete('/floating-btn/{floatingButton}/logo',     [WebConfigController::class, 'destroyFloatingButtonLogo'])->name('floating-btn.logo.destroy');
            Route::get('/edit-contacto',              [WebConfigController::class, 'editContacto'])->name('edit-contacto');
            Route::post('/edit-contacto',             [WebConfigController::class, 'updateEditContacto'])->name('edit-contacto.update');
            Route::delete('/edit-contacto/{key}',     [WebConfigController::class, 'destroyContactIcon'])->name('edit-contacto.icon-destroy');
            Route::get('/icono',              [WebConfigController::class, 'icono'])->name('icono');
            Route::post('/icono',             [WebConfigController::class, 'iconoUpdate'])->name('icono.update');
            Route::delete('/icono',           [WebConfigController::class, 'iconoDestroy'])->name('icono.destroy');
            Route::post('/{key}',   [WebConfigController::class, 'update'])->name('update');
            Route::delete('/{key}', [WebConfigController::class, 'destroy'])->name('destroy');
        });

        // Usuarios Admin (solo admin global)
        Route::middleware('can:admin-only')->prefix('usuarios')->name('usuarios.')->group(function () {
            Route::get('/', [UserAdminController::class, 'index'])->name('index');
            Route::post('/', [UserAdminController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserAdminController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserAdminController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserAdminController::class, 'destroy'])->name('destroy');
            Route::post('/{user}/reset-password', [UserAdminController::class, 'resetPassword'])->name('reset-password');
            Route::delete('/', [UserAdminController::class, 'bulkDestroy'])->name('bulk-destroy');
        });
    });
});
