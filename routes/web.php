<?php

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

Route::get('/admin', function () {
    return view('login');
});


Route::get('/PrivacyPolicy', function () {
    return view('privacy_policy');
});
Route::get('/Terms&Conditions', function () {
    return view('Terms_Conditions');
});
Route::post('/forgot_password','Login@forgot_password');

Route::post('/login_process','Login@login_process');

Route::middleware(['disablepreventback'])->group(function () {


	//=====================================   Dashboard   ========================================//
		Route::get('/welcome', function () {
			$get_user = \DB::table('tbl_user')->where(['is_deleted' => 0])->count();
			$get_recipe = \DB::table('tbl_recipe')->where(['is_deleted' => 0])->count();
			$get_cat = \DB::table('tbl_category')->where(['is_deleted' => 0])->count();
			$premium = \DB::table('tbl_user')->where(['subscription_id' => 2, 'is_deleted' => 0])->count();

		    return view('dashboard_view',['menu_name' => 'welcome','users' => $get_user,'recipe'=>$get_recipe,'category' => $get_cat , 'premium' => $premium]);
		});

		Route::get('/user','User@user_index');

		Route::post('/view_user','User@view_user');

		Route::post('/delete_user','User@user_delete');

		Route::post('/block_user','User@user_block');

		//============================category===========================//

		Route::get('/Category','Category@category');

		Route::post('/view_category_list','Category@view_category_list');

		Route::post('/add_category','Category@add_category');

		Route::post('/category_delete','Category@category_delete');

		Route::post('/edit_category','Category@edit_category');
		
		Route::post('/update_category','Category@update_category');

		Route::get('/Category/{id}','Category@view_category_detail');

		//============================Recipe===========================//

		Route::get('/Recipe','Recipe@recipe');

		
        Route::post('/view_recipe_list','Recipe@view_recipe_list')->name('view_recipe_list');

		Route::post('/add_recipe','Recipe@add_recipe');
		

		Route::post('/recipe_delete','Recipe@recipe_delete');

		Route::post('/edit_recipe','Recipe@edit_recipe');
		
		Route::post('/update_recipe/{id}','Recipe@update_recipe');

		Route::get('/recipe','Recipe@add_recipe_view')->name('add_recipe');

		Route::post('/add_ingredients/{id}','Recipe@add_ingredients');

		Route::get('/Recipe/{id}','Recipe@edit_recipe_view')->name('edit_recipe');

		Route::get('/get_recipe_image/{id}','Recipe@get_recipe_image');

		Route::get('/Recipe/Details/{id}','Recipe@recipe_details')->name('recipe_details');

		Route::post('/get_ingredients','Recipe@get_ingredients');

		Route::post('/edit_ingredients','Recipe@edit_ingredients');

		Route::post('/update_ingredients','Recipe@update_ingredients');

		Route::post('/ingredients_delete','Recipe@ingredients_delete');

		Route::post('/update_ingredients_details','Recipe@update_ingredients_details');

		Route::post('/get_image','Recipe@get_image');
		
		Route::post('/add_image/{id}','Recipe@add_image');

		Route::post('/image_delete','Recipe@image_delete');

		Route::post('/update_video/{id}','Recipe@update_video');

		Route::post('/get_recipe_ingredients','Recipe@get_recipe_ingredients');

		Route::get('/change_password', function () {
	    	return view('change_password_view',['menu_name' => '']);
		});

		Route::post('/change_password','Login@change_password');

		Route::get('/logout','Login@logout');
		
		Route::get('/hide_show_recipe','Recipe@hide_show_recipe');

		//===============================premium members===============================//

		Route::get('/Premium_Members','User@Premium_Members');

		Route::post('/premium_members_list','User@premium_members_list');
		
		Route::get('/Sort_category','Category@sort_category_view')->name('sort_category');

		Route::post('/sort_category','Category@sort_category');
});