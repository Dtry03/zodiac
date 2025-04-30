<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Signup;

class ClientAreaController extends Controller
{
   public function myClasses(){
        $userId = Auth::id();

        $userSignups= Signup::where('id_user', $userId)
                            ->with(['gymClass' => function($query){
                                    $query->with(['category', 'instructor']);
                            }])->get();
        return view('client.my_classes', compact('userSignups'));
   }
}
