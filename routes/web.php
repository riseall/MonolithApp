<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            // 'laravelVersion' => Application::VERSION,
            // 'phpVersion' => PHP_VERSION,
        ]);
    });
});



Route::get('auth/google', [ProviderController::class, 'redirect'])->name('googleAuth');
Route::get('auth/google/callback', [ProviderController::class, 'callbackGoogle']);

// Route::get('/homes', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/userP', [UserProfileController::class, 'edit'])->name('userP.edit');
    Route::patch('/userP', [UserProfileController::class, 'update'])->name('userP.update');
    Route::delete('/userP', [UserProfileController::class, 'destroy'])->name('userP.destroy');

    Route::middleware(['checkAdmin'])->group(function () {
        // Route untuk Tampilan Admin
        Route::get('dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->middleware('checkAdmin');

        Route::get('user', function () {
            return Inertia::render('Admin/User');
        });
        Route::get('mahasiswa', function () {
            return Inertia::render('Admin/Mahasiswa');
        });
        Route::get('dosen', function () {
            return Inertia::render('Admin/Dosen');
        });

        Route::get('perusahaan', function () {
            return Inertia::render('Admin/Perusahaan');
        });

        Route::get('magang', function () {
            return Inertia::render('Admin/Magang');
        });
        Route::get('absensi', function () {
            return Inertia::render('Admin/Absensi');
        });
        Route::get('laporan', function () {
            return Inertia::render('Admin/Laporan');
        });
    });

    // Route untuk Tampilan User

    Route::get('user.dashboard', function () {
        return Inertia::render('User/Dashboard');
    })->name('user.dashboard');

    Route::get('user.history', function () {
        return Inertia::render('User/History');
    });

    Route::get('user.profile', function () {
        return Inertia::render('User/Profile');
    });

    Route::get('user.keamanan', function () {
        return Inertia::render('User/Keamanan');
    });

    Route::get('user.location', function () {
        return Inertia::render('User/Location');
    });

    Route::get('user.setting', function () {
        return Inertia::render('User/Setting');
    });

    Route::get('user.perusahaan', function () {
        return Inertia::render('User/Perusahaan');
    });

    Route::get('user.magang', function () {
        return Inertia::render('User/Magang');
    });

    Route::get('user.laporan', function () {
        return Inertia::render('User/Laporan');
    });

    Route::name('user.mahasiswa')->get('/createMahasiswa', function () {
        return Inertia::render('User/createMahasiswa');
    });
});

Route::get('pegawai', function () {
    return Inertia::render('Pegawai/Index');
});

Route::get('home', function () {
    return Inertia::render('App');
});




require __DIR__ . '/auth.php';