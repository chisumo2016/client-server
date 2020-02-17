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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redirect' ,function (){
    $query = http_build_query([
   'client_id'          => '4',
    'redirect_uri'      => 'http://client-server.application/callback',  // client server
     'response_type'   =>'code',
        'scope'          =>''
    ]);

    return redirect('http://polling-voting-api.application/oauth/authorize?' .$query);  //application server polling community
});

Route::get('/callback', function (Illuminate\Http\Request $request){
    $http = new \GuzzleHttp\Client;

    $response  = $http->post('http://polling-voting-api.application/oauth/token',[  //application server polling community
        'form_params' =>[
            'client_id'          => '4',
            'client_secret'  =>'NhAgouzeN0LMDWHjfR0VIBUnp4yKSpQHrdxJkd6b',  //application poll
            'grant_type'  =>'authorization_code',
            'redirect_uri' => 'http://client-server.application/callback' ,  // client server
            'code' => $request->code
        ],
    ]);

    return json_decode((string)  $response->getBody(), true);

});
