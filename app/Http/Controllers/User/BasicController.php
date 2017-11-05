<?php
/**
 * Created by PhpStorm.
 * User: ohrus
 * Date: 05.11.2017
 * Time: 17:58
 */

namespace App\Http\Controllers\User;

use App\User;
use App\Http\Controllers\Controller;

class BasicController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user_profile', ['user' => $user]);
    }
}