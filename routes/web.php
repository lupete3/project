<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
  return redirect()->route('dashboard');
});

Route::view('dashboard', 'dashboard')
  ->middleware(['auth', 'verified'])
  ->name('dashboard');

Route::middleware(['auth'])->group(function () {
  Route::get('/debug-test', function () {
    return 'Debug Route Works!';
  });
  Route::redirect('settings', 'settings/profile');

  Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
  Volt::route('settings/password', 'settings.password')->name('settings.password');
  Route::get('settings/company', function () {
    return view('settings.company');
  })->name('settings.company');

  // Projects
  Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
  Route::get('/projects/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');
  Route::get('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show')->where('project', '[0-9]+');
  Route::get('/projects/{project}/edit', [App\Http\Controllers\ProjectController::class, 'edit'])->name('projects.edit')->where('project', '[0-9]+');

  // Clients
  Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');
  Route::get('/clients/create', [App\Http\Controllers\ClientController::class, 'create'])->name('clients.create');
  Route::get('/clients/{client}', [App\Http\Controllers\ClientController::class, 'show'])->name('clients.show')->where('client', '[0-9]+');
  Route::get('/clients/{client}/edit', [App\Http\Controllers\ClientController::class, 'edit'])->name('clients.edit')->where('client', '[0-9]+');

  // Tasks
  Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
  Route::get('/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
  Route::get('/tasks/{task}/edit', [App\Http\Controllers\TaskController::class, 'edit'])->name('tasks.edit')->where('task', '[0-9]+');

  // Finances
  Route::get('/finances', App\Livewire\Finances\FinancialOverview::class)->name('finances.index');
  Route::get('/finances/revenues/create', function () {
    return view('finances.revenues.create');
  })->name('finances.revenues.create');
  Route::get('/finances/expenses/create', function () {
    return view('finances.expenses.create');
  })->name('finances.expenses.create');

  // Invoices
  Route::get('/invoices', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices.index');
  Route::get('/invoices/create', [App\Http\Controllers\InvoiceController::class, 'create'])->name('invoices.create');
  Route::get('/invoices/{invoice}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoices.show')->where('invoice', '[0-9]+');
  Route::get('/invoices/{invoice}/edit', [App\Http\Controllers\InvoiceController::class, 'edit'])->name('invoices.edit')->where('invoice', '[0-9]+');
  Route::get('/invoices/{invoice}/download', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download')->where('invoice', '[0-9]+');

  // Renewals
  Route::get('/renewals', [App\Http\Controllers\RenewalController::class, 'index'])->name('renewals.index');
  Route::get('/renewals/create', [App\Http\Controllers\RenewalController::class, 'create'])->name('renewals.create');
  Route::get('/renewals/{renewal}/edit', [App\Http\Controllers\RenewalController::class, 'edit'])->name('renewals.edit')->where('renewal', '[0-9]+');

  // Team
  Route::get('/team', [App\Http\Controllers\TeamController::class, 'index'])->name('team.index');
  Route::get('/team/create', [App\Http\Controllers\TeamController::class, 'create'])->name('team.create');
  Route::get('/team/{user}/edit', [App\Http\Controllers\TeamController::class, 'edit'])->name('team.edit')->where('user', '[0-9]+');

  // Reports
  Route::get('/reports', App\Livewire\Reports\ReportOverview::class)->name('reports.index');
});

require __DIR__ . '/auth.php';
