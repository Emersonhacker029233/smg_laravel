<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\RoleAssign;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

// Profile Routes
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::get('/profile/edit', [HomeController::class, 'profileEdit'])->name('profile.edit');
Route::put('/profile/update', [HomeController::class, 'profileUpdate'])->name('profile.update');
Route::get('/profile/changepassword', [HomeController::class, 'changePasswordForm'])->name('profile.change.password');
Route::post('/profile/changepassword', [HomeController::class, 'changePassword'])->name('profile.changepassword');

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {

    // Role & Permission Management
    Route::get('/roles-permissions', [RolePermissionController::class, 'roles'])->name('roles-permissions');
    Route::get('/role-create', [RolePermissionController::class, 'createRole'])->name('role.create');
    Route::post('/role-store', [RolePermissionController::class, 'storeRole'])->name('role.store');
    Route::get('/role-edit/{id}', [RolePermissionController::class, 'editRole'])->name('role.edit');
    Route::put('/role-update/{id}', [RolePermissionController::class, 'updateRole'])->name('role.update');

    Route::get('/permission-create', [RolePermissionController::class, 'createPermission'])->name('permission.create');
    Route::post('/permission-store', [RolePermissionController::class, 'storePermission'])->name('permission.store');
    Route::get('/permission-edit/{id}', [RolePermissionController::class, 'editPermission'])->name('permission.edit');
    Route::put('/permission-update/{id}', [RolePermissionController::class, 'updatePermission'])->name('permission.update');

    // Assign Subjects to Class
    Route::get('assign-subject-to-class/{id}', [GradeController::class, 'assignSubject'])->name('class.assign.subject');
    Route::post('assign-subject-to-class/{id}', [GradeController::class, 'storeAssignedSubject'])->name('store.class.assign.subject');

    // Resource Controllers
    Route::resource('assignrole', RoleAssign::class);
    Route::resource('classes', GradeController::class);
    Route::resource('subject', SubjectController::class);
    Route::resource('teacher', TeacherController::class);
    Route::resource('parents', ParentsController::class);
    Route::resource('student', StudentController::class);

    // Attendance
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
});

// Teacher Routes
Route::middleware(['auth', 'role:Teacher'])->group(function () {
    Route::post('attendance', [AttendanceController::class, 'store'])->name('teacher.attendance.store');
    Route::get('attendance-create/{classid}', [AttendanceController::class, 'createByTeacher'])->name('teacher.attendance.create');
});

// Parent Routes
Route::middleware(['auth', 'role:Parent'])->group(function () {
    Route::get('attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
});

// Student Routes
Route::middleware(['auth', 'role:Student'])->group(function () {
    // No routes defined yet
});
