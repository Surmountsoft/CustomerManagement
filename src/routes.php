<?php
use CSoftech\Customer\Http\Controllers\RoleController;
use CSoftech\Customer\Http\Controllers\UserController;
use CSoftech\Customer\Http\Controllers\CustomerController;
	
	Route::resource('/roles',RoleController::class);
	Route::get('/roles-data', [RoleController::class, 'rolesData'])->name('roles.data');
	Route::post('roles-toggle-status/{id}', [RoleController::class, 'toggleStatus'])->name('role.toggle.status');

	Route::resource('/users',UserController::class);
	Route::get('/users-data', [UserController::class, 'usersData'])->name('users.data');
	Route::put('users/block-unblock/{user}', [UserController::class, 'blockUnblock'])->name('users.block-unblock');

	Route::resource('/customers',CustomerController::class);
	Route::get('/country-states', [CustomerController::class, 'countryStates'])->name('country.states');
	Route::get('/state-cities', [CustomerController::class, 'stateCities'])->name('state.cities');
	Route::get('/customers-data', [CustomerController::class, 'customersData'])->name('customers.data');
	Route::put('customers/block-unblock/{customer}', [CustomerController::class, 'blockUnblock'])->name('customers.block-unblock');
