<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GithubController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\EbookController;
use App\Http\Controllers\Dashboard\EpisodeController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolePermission\PermissionController;
use App\Http\Controllers\Dashboard\RolePermission\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SubCourseController;
use App\Http\Controllers\Dashboard\User\ArchivedUserController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Middleware\CheckAccountActivation;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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

Route::get('/lang/{lang}', function ($lang) {
    // dd($lang);
    if(! in_array($lang, ['en','fr','ar','de'])){
        abort(404);
    }else{
        session(['locale' => $lang]);
        App::setLocale($lang);
        Log::info("Locale set to: " . $lang);
        return redirect()->back();
    }
})->name('lang');

Route::get('/current-time', function () {
    return response()->json([
        'time' => Carbon::now()->format('h:iA') // Returns time in 12-hour format with AM/PM
    ]);
});

Auth::routes();
// Route::get('/', function () {
    //     return redirect()->route('frontend.home');
    // });
    // Guest Routes
Route::group(['middleware' => ['guest']], function () {

    //User Login Authentication Routes
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login-attempt', [LoginController::class, 'login_attempt'])->name('login.attempt');

    //User Register Authentication Routes
    Route::get('register', [RegisterController::class, 'register'])->name('register');
    Route::post('registration-attempt', [RegisterController::class, 'register_attempt'])->name('register.attempt');

    // Google Authentication Routes
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.login');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.login.callback');
    // Github Authentication Routes
    Route::get('auth/github', [GithubController::class, 'redirectToGithub'])->name('auth.github.login');
    Route::get('auth/github/callback', [GithubController::class, 'handleGithubCallback'])->name('auth.github.login.callback');
    // Facebook Authentication Routes
    // Route::controller(FacebookController::class)->group(function () {
    //     Route::get('auth/facebook', 'redirectToFacebook')->name('auth.facebook');
    //     Route::get('auth/facebook/callback', 'handleFacebookCallback');
    // });

});

// Authentication Routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('login-verification', [AuthController::class, 'login_verification'])->name('login.verification');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('verify-account', [AuthController::class, 'verify_account'])->name('verify.account');
    Route::post('resend-code', [AuthController::class, 'resend_code'])->name('resend.code');

    // Verified notification
    Route::get('email/verify/{id}/{hash}', [AuthController::class, 'verification_verify'])->middleware(['signed'])->name('verification.verify');
    Route::get('email/verify', [AuthController::class, 'verification_notice'])->name('verification.notice');
    Route::post('email/verification-notification', [AuthController::class, 'verification_send'])->middleware(['throttle:2,1'])->name('verification.send');
    // Verified notification
});

Route::middleware(['auth'])->group(function () {
    Route::get('/deactivated', function () {
        return view('errors.deactivated');
    })->name('deactivated');
    Route::get('/expiry', function () {
        return view('errors.expiry');
    })->name('expiry');
    Route::middleware(['check.activation'])->group(function () {
        Route::get('/', [FrontendHomeController::class, 'home'])->name('home');
        Route::resource('profile', ProfileController::class);
        Route::post('profile/setting/account/{id}', [ProfileController::class, 'accountDeactivation'])->name('account.deactivate');
        Route::post('profile/security/password/{id}', [ProfileController::class, 'passwordUpdate'])->name('update.password');

        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
        Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
        Route::post('/notifications/{id}/delete', [NotificationController::class, 'deleteNotification']);
        Route::get('/notifications/send-test-noti/{id}', [NotificationController::class, 'testNotification']);

        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

        // Admin Dashboard Authentication Routes
        Route::prefix('dashboard')->name('dashboard.')->group(function () {

            Route::resource('user', UserController::class);
            Route::resource('archived-user', ArchivedUserController::class);
            Route::get('user/restore/{id}', [ArchivedUserController::class, 'restoreUser'])->name('archived-user.restore');
            Route::get('user/status/{id}', [UserController::class, 'updateStatus'])->name('user.status.update');

            // Role & Permission Start
            Route::resource('permissions', PermissionController::class);

            Route::resource('roles', RoleController::class);
            //Role & Permission End

            // Setting Routes
            Route::resource('setting', SettingController::class);
            Route::put('company/setting/{id}', [SettingController::class, 'updateCompanySettings'])->name('setting.company.update');
            Route::put('recaptcha/setting/{id}', [SettingController::class, 'updateRecaptchaSettings'])->name('setting.recaptcha.update');
            Route::put('system/setting/{id}', [SettingController::class, 'updateSystemSettings'])->name('setting.system.update');
            Route::put('email/setting/{id}', [SettingController::class, 'updateEmailSettings'])->name('setting.email.update');
            Route::post('send-mail/setting', [SettingController::class, 'sendTestMail'])->name('setting.send_test_mail');

            // User Dashboard Authentication Routes

            //Courses
            Route::resource('courses', CourseController::class);
            Route::get('courses/{id}/reviews', [CourseController::class, 'courseReviews'])->name('courses.reviews');
            Route::get('courses/{id}/reviews/create', [CourseController::class, 'courseReviewCreate'])->name('courses.reviews.create');
            Route::post('courses/{id}/reviews/store', [CourseController::class, 'courseReviewStore'])->name('courses.reviews.store');
            Route::get('courses/reviews/edit/{id}', [CourseController::class, 'courseReviewEdit'])->name('courses.reviews.edit');
            Route::put('courses/reviews/update/{id}', [CourseController::class, 'courseReviewUpdate'])->name('courses.reviews.update');
            Route::delete('courses/reviews/delete/{id}', [CourseController::class, 'courseReviewDestroy'])->name('courses.reviews.delete');

            //SubCourses
            Route::resource('subcourses', SubCourseController::class);

            //Ebooks
            Route::resource('ebooks', EbookController::class);

            //Episodes
            Route::resource('episodes', EpisodeController::class);




        });

            // Frontend Pages Routes
        Route::name('frontend.')->group(function () {
            Route::get('novels', [FrontendHomeController::class, 'home'])->name('home');
            Route::get('new-episodes', [FrontendHomeController::class, 'newEpisodes'])->name('new.episodes');
            Route::get('novels-deatils/{id}', [FrontendHomeController::class, 'novelDetails'])->name('novel.details');
            Route::get('subcourses/{id}', [FrontendHomeController::class, 'subcourseDetails'])->name('subcourse.details');
            Route::get('read_novel/{id}', [FrontendHomeController::class, 'readNovel'])->name('read.novel');
            Route::post('reviews/store/{id}', [FrontendHomeController::class, 'storeReview'])->name('reviews.store');
            Route::get('add/favourite/{id}', [FrontendHomeController::class, 'addFavourite'])->name('add.favourite');
            Route::get('my/favourite', [FrontendHomeController::class, 'myFavourites'])->name('my-favourites');
        });
    });
    Route::get('users/json', [UserController::class, 'json'])->name('users.json');
    Route::get('courses/json', [CourseController::class, 'json'])->name('courses.json');
    Route::get('get-json/subcourses', [SubCourseController::class, 'json'])->name('subcourses.json');
    Route::get('ebooks/json', [EbookController::class, 'json'])->name('ebooks.json');
    Route::get('episodes/json', [EpisodeController::class, 'json'])->name('episodes.json');
});

//Artisan Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        return "Application cache cleared!";
    })->name('clear.cache');

    Route::get('/clear-config', function () {
        Artisan::call('config:clear');
        return "Configuration cache cleared!";
    })->name('clear.config');

    Route::get('/clear-view', function () {
        Artisan::call('view:clear');
        return "View cache cleared!";
    })->name('clear.view');

    Route::get('/clear-route', function () {
        Artisan::call('route:clear');
        return "Route cache cleared!";
    })->name('clear.route');

    Route::get('/clear-optimize', function () {
        Artisan::call('optimize:clear');
        return "Optimization cache cleared!";
    })->name('clear.optimize');
});

