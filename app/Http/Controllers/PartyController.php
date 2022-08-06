<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function createParty(Request $request){

        try {
           
        } catch (\Exception $exception) {
           Log::error('Error to create a new party' .$exception->getMessage());
        }




    }
}
