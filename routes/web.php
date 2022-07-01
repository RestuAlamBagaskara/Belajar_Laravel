<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/alam', function () {
    return '<h1>Alam</h1>';
});


Route::view('/hello', 'hello', ['name' => 'alam']);

Route::get('/hello-again', function (){
    return view('hello', ['name' => 'alam']);
});

Route::get('/hello-world', function (){
    return view('hello.world', ['name' => 'alam']);
});

Route::get('/products/{id}', function ($productId){
    return "Product $productId";
})->name('product.detail');//memberikan nama pada route

Route::get('/products/{product}}/items/{item}', function ($productId, $itemId){
    return "Product $productId, Item $itemId";
})->name('product.item.detail');//memberikan nama pada route

//Route parameter dengan menggunakan regex
Route::get('/categories/{id}', function ($categoryId){
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail'); //memberikan nama pada route

//memberikan route parameter optional
Route::get('/users/{id?}', function ($userId = '404'){
    return "User $userId";
})->name('user.detail');//memberikan nama pada route

//Route yang akan terjadi conflict
//dieksekusi yang pertama kali
Route::get('/conflict/alam', function (){
    return "Conflict Alam";
});

//Menggunakan route parameters
Route::get('/conflict/{name}', function ($name){
    return "Conflict $name";
});

//memberikan nama oada route
Route::get('/produk/{id}', function ($id){
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get('/produk-redirect/{id}', function ($id){
    return redirect()->route('product.detail', ['id' => $id]);
});

//memnggunakan route dengan controller
Route::get('/controller/hello/request', [\App\Http\Controllers\HelloController::class, 'request']);
Route::get('/controller/hello/{name}', [\App\Http\Controllers\HelloController::class, 'hello']);

//menggunakan request input
Route::get('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']);
Route::post('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']);
Route::post('/input/hello/first', [\App\Http\Controllers\InputController::class, 'helloFirstName']);
Route::post('/input/hello/input', [\App\Http\Controllers\InputController::class, 'helloInput']);
Route::post('/input/hello/array', [\App\Http\Controllers\InputController::class, 'helloArray']);
Route::post('/input/type', [\App\Http\Controllers\InputController::class, 'inputType']);

//menggunakan filter input
Route::post('/input/filter/only', [\App\Http\Controllers\InputController::class, 'filterOnly']);
Route::post('/input/filter/except', [\App\Http\Controllers\InputController::class, 'filterExcept']);
Route::post('/input/filter/merge', [\App\Http\Controllers\InputController::class, 'filterMerge']);

//file upload
Route::post('/file/upload', [\App\Http\Controllers\FileController::class, 'upload'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

//response
Route::get('/response/hello', [\App\Http\Controllers\ResponseController::class, 'response']);
Route::get('/response/header', [\App\Http\Controllers\ResponseController::class, 'header']);

//mengembalikan response dalam bentuk yang berbeda beda
Route::prefix("/response/type")->group(function (){
    Route::get('/view', [\App\Http\Controllers\ResponseController::class, 'responseView']);
    Route::get('/json', [\App\Http\Controllers\ResponseController::class, 'responseJson']);
    Route::get('/file', [\App\Http\Controllers\ResponseController::class, 'responseFile']);
    Route::get('/download', [\App\Http\Controllers\ResponseController::class, 'responseDownload']);
});

//Menggunakan cookie
Route::controller(\App\Http\Controllers\CookieController::class)->group(function (){
    Route::get('/cookie/set', 'createCookie');
    Route::get('/cookie/get', 'getCookie');
    Route::get('/cookie/clear', 'clearCookie');
});

//Menggunakan redirect
Route::get('/redirect/from', [\App\Http\Controllers\RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to', [\App\Http\Controllers\RedirectController::class, 'redirectTo']);

//menggunakan redirect dengan nama route
Route::get('/redirect/name', [\App\Http\Controllers\RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}', [\App\Http\Controllers\RedirectController::class, 'redirectHello'])
    ->name('redirect-hello');

Route::get('/redirect/named', function (){
//    return route('redirect-hello', ['name' => 'alam']);
//    return url()->route('redirect-hello', ['name' => 'alam']);
    return \Illuminate\Support\Facades\URL::route('redirect-hello', ['name' => 'alam']);
});

Route::get('/redirect/action', [\App\Http\Controllers\RedirectController::class, 'redirectAction']);
Route::get('/redirect/away', [\App\Http\Controllers\RedirectController::class, 'redirectAway']);

//menggunakan middleware dalam route
//menggunnakan middleware group dalam route
Route::middleware(['contoh:PZN,401'])->prefix('/middleware')->group(function (){
    Route::get('/api', function (){
        return "OK";
    });
    Route::get('/group', function (){
        return "GROUP";
    });
});

Route::get('/url/action', function (){
    // return action([\App\Http\Controllers\FormController::class, 'form'], []);
    // return url()->action([\App\Http\Controllers\FormController::class, 'form'], []);
    return \Illuminate\Support\Facades\URL::action([\App\Http\Controllers\FormController::class, 'form'], []);
});

//mencoba CSRF tokenRoute Controller

Route::get('/form', [\App\Http\Controllers\FormController::class, 'form']);
Route::post('/form', [\App\Http\Controllers\FormController::class, 'submitForm']);

Route::get('/url/current', function (){
    return \Illuminate\Support\Facades\URL::full();
});

Route::get('/session/create', [\App\Http\Controllers\SessionController::class, 'createSession']);
Route::get('/session/get', [\App\Http\Controllers\SessionController::class, 'getSession']);

Route::get('/error/sample', function (){
    throw new Exception("Sample Error");
});

//mengembalikan exception error 
Route::get('/error/manual', function (){
    report(new Exception("Sample Error"));
    return "OK";
});

Route::get('/abort/400', function (){
    abort(400, "Ups Validation Error");
});

Route::get('/abort/401', function (){
    abort(401);
});

Route::get('/abort/500', function (){
    abort(500);
});

