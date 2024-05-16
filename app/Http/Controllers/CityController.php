<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function storeCities(Request $request){
        $data = $request->data;
        if( $data){
            DB::beginTransaction();
            DB::table("cities")->insert($data);
            DB::commit();
        }
    }
    public function getCities(Request $request){
        $cities = DB::table("cities")->get();
        return response()->json($cities, 200);
    }
}
