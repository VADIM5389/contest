<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\JuryController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ===== AUTH =====
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== PROTECTED (AUTH) =====
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ===== SUBMISSIONS (participant) =====
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');

    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::put('/submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
    Route::post('/submissions/{submission}/submit', [SubmissionController::class, 'submit'])->name('submissions.submit');

    // ===== ATTACHMENTS (FILES) =====
    Route::post('/submissions/{submission}/attachments', [AttachmentController::class, 'upload'])->name('attachments.upload');
    Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');

    // ===== JURY (jury OR admin) =====
    Route::middleware('role:jury,admin')->group(function () {
        Route::get('/jury', [JuryController::class, 'index'])->name('jury.index');
        Route::get('/jury/submissions/{submission}', [JuryController::class, 'show'])->name('jury.submissions.show');
        Route::post('/jury/submissions/{submission}/status', [JuryController::class, 'setStatus'])->name('jury.submissions.status');
        Route::post('/jury/submissions/{submission}/comment', [JuryController::class, 'comment'])->name('jury.submissions.comment');
    });

    // ===== ADMIN (admin only) =====
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/admin/users/{user}/role', [AdminController::class, 'setRole'])->name('admin.users.role');
    });
});
 