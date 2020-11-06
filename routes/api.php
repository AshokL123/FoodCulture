<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('email_verification/{user_id}', 'api\UserController@email_verification');

Route::post('user_registration', 'api\UserController@user_registration');

Route::post('user_login', 'api\UserController@user_login');

Route::post('forgot_email_password', 'api\UserController@forgot_email_password');

Route::middleware(['auth_api'])->group(function () {

	Route::post('category_list', 'api\UserController@category_list');

	Route::post('recipe_list', 'api\UserController@recipe_list');

	Route::post('get_recipe_details', 'api\UserController@get_recipe_details');

	Route::post('user_favorite_recipe', 'api\UserController@user_favorite_recipe');

	Route::post('user_add_notes', 'api\UserController@user_add_notes');

	Route::post('user_add_rate', 'api\UserController@user_add_rate');

	Route::post('user_add_fav_recipe', 'api\UserController@user_add_fav_recipe');

	Route::post('create_shoppinglist', 'api\UserController@create_shoppinglist');

	Route::post('remove_fav_recipe', 'api\UserController@remove_fav_recipe');

	Route::post('remove_shopping_list', 'api\UserController@remove_shopping_list');

	Route::post('get_shopping_list', 'api\UserController@get_shopping_list');

	Route::post('user_purchase', 'api\UserController@user_purchase');

	Route::post('change_password', 'api\UserController@change_password');

	Route::post('edit_user_profile', 'api\UserController@edit_user_profile');

	Route::post('search_recipe_list', 'api\UserController@search_recipe_list');

	Route::post('remove_item', 'api\UserController@remove_item');

	Route::post('recipe_list_by_category', 'api\UserController@recipe_list_by_category');

	Route::post('get_user_review', 'api\UserController@get_user_review');
	
	Route::post('cancel_user_subscription', 'api\UserController@cancel_user_subscription');

	
});