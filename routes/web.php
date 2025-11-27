<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\OtpVerification;

Route::middleware(['guest'])->group( function() {
    Route::view('/', 'website.home')->name('home');
    Route::view('/about', 'website.about')->name('about');
    Route::view('/contacts', 'website.contacts')->name('contacts');
    Route::view('/careers', 'website.careers')->name('careers');
    Route::view('/application', 'website.application')->name('application');
    Route::view('/company', 'website.company')->name('company');

    //Auth routes
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/otp-verification', 'auth.otp-verification')->name('otp.verify');
    Route::view('/register', 'auth.register')->name('register');

});

Route::middleware(['auth'])->group( function() {
    // Employees routes
    Route::view('/dashboard', 'employee.dashboard')->name('dashboard');
    Route::view('/requisitions', 'employee.recruitment.requisitions')->name('requisitions');
    Route::view('/job-postings', 'hr1.recruitment_management.job-postings')->name('job-postings');

});




