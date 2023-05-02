<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserDashController;
use App\Http\Controllers\UserTodoController;
use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
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

Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('update-password');
Route::get('/profile-update', [HomeController::class, 'updateProfile'])->name('update-profile');
Route::POST('/profile-update', [HomeController::class, 'updateProfileStore'])->name('update-profile-store');

Route::prefix('auth/google')->name('google.')->group( function(){
    Route::get('/', [GoogleController::class, 'loginWithGoogle'])->name('login');
    Route::any('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
});

Auth::routes(['verify' => true]);
Auth::routes();
// USER ROUTE

Route::group(['middleware' => ['auth', 'user', 'verified']], function () {
    Route::get('/', [UserDashController::class, 'index'])->name('home');
    Route::get('/home', [UserDashController::class, 'home'])->name('user.dash');
    Route::resource('notes', NoteController::class);
    Route::resource('notes.todos', UserTodoController::class)->shallow();
    Route::get('notes/done/{id}', [UserDashController::class, 'noteDone'])->name('notes.done');
    Route::get('notes/archive/{id}', [UserDashController::class, 'noteArchive'])->name('notes.archive');
    Route::get('/archive/notes', [UserDashController::class, 'archiveNote'])->name('archive.note');
    Route::get('/unarchive/notes/{id}', [UserDashController::class, 'noteUnarchive'])->name('notes.unarchive');
    Route::get('notes/todos/done/{id}', [UserDashController::class, 'todoDone'])->name('todo.done');
    Route::get('notes/todos/pending/{id}', [UserDashController::class, 'todoPending'])->name('todo.pending');
    Route::get('notes/generate-pdf/{id}', [UserDashController::class, 'generatePDF'])->name('note.pdf');
    Route::post('notes/todos/reorder', [UserTodoController::class, 'reorder'])->name('todos.reorder');
    Route::get('note/{tag}', [UserDashController::class, 'tagNotes'])->name('notes.tag');
});




// Route::any('tags', function () {
//     $search = preg_replace('/\s*, \s*/', '|', 'jun');

//     $temp = Note::whereRaw("tag_id REGEXP '{$search}'")->get();
//     // $temp = Note::where('tag_id', 'jun')->get();
//     dd($temp);
// });




// ADMIN ROUTE
Route::get('/admin_dashboard', [AdminDashController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.dash');


Route::get('note', [AdminDashController::class, 'notes'])->middleware(['auth', 'admin'])->name('admin.notes');
Route::get('note/{id}/todos', [AdminDashController::class, 'todos'])->middleware(['auth', 'admin'])->name('admin.todos');


Route::resource('users', AdminController::class)->middleware(['auth', 'admin']);

Route::get('user/ban/{id}', [AdminDashController::class, 'userBan'])->middleware(['auth', 'admin'])->name('admin.ban');

Route::get('user/unban/{id}', [AdminDashController::class, 'userActive'])->middleware(['auth', 'admin'])->name('admin.unban');





