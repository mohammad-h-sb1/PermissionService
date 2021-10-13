<?php
use Illuminate\Support\Facades\Route;
use Saberyp\Cms\App\Http\PermissionController;
use Saberyp\Cms\App\Http\ProfileController;
use Saberyp\Cms\App\Http\RoleController;
use Saberyp\Cms\App\Http\UserController;
use Saberyp\Cms\App\Http\Admin\ProfileController as AdminProfileController;

Route::middleware('auth:api')->group(function (){
    Route::get('test',function (){
        return auth()->user();
    });
});
Route::middleware('auth:api')->group(function (){
    Route::prefix('amin')->group(function (){
        Route::prefix('profile')->group(function (){
            Route::get('list',[AdminProfileController::class,'index']);
            Route::get('show/{id}',[AdminProfileController::class,'show']);
            Route::get('edit/{id}',[AdminProfileController::class,'edit']);
            Route::put('update/{id}',[AdminProfileController::class,'update']);
        });
    });

    Route::name('front')->group(function (){
        Route::prefix('permission')->group(function (){
            Route::get('/list',[PermissionController::class,'index'])->middleware('can:permission_list,user');
            Route::post('/create',[PermissionController::class,'store'])->middleware('can:permission_store,user');
            Route::get('/show/{id}',[PermissionController::class,'show'])->middleware('can:permission_show,user');
            Route::get('/edit/{id}',[PermissionController::class,'edit'])->middleware('can:permission_edit,user');
            Route::put('/update/{id}',[PermissionController::class,'update'])->middleware('can:permission_update,user');
            Route::delete('/delete/{id}',[PermissionController::class,'delete'])->middleware('can:permission_delete,user');
        });

        Route::prefix('role')->group(function (){
            Route::get('list',[RoleController::class,'index']);
            Route::post('create',[RoleController::class,'store']);
            Route::get('show/{id}',[RoleController::class,'show']);
            Route::get('edit/{id}',[RoleController::class,'edit']);
            Route::put('update/{id}',[RoleController::class,'update']);
        });

        Route::prefix('user')->group(function (){
            Route::get('list',[UserController::class,'index']);
            Route::post('create',[UserController::class,'store']);
            Route::get('show/{id}',[UserController::class,'show']);
            Route::get('edit/{id}',[UserController::class,'edit']);
            Route::put('update/{id}',[UserController::class,'update']);
            Route::delete('update/{id}',[UserController::class,'update']);
        });

        Route::prefix('profile')->group(function (){
            Route::get('show',[ProfileController::class,'show']);
            Route::get('edit',[ProfileController::class,'edit']);
            Route::put('update',[ProfileController::class,'update']);
        });

        Route::post('logout/user',[UserController::class,'logout']);
    });
});

if (auth()->user()){
    Route::get('test',function (){
        dd(auth()->user());
    });
}
else{
    Route::post('register/user',[UserController::class,'register']);
    Route::post('login/user',[UserController::class,'login']);
}

