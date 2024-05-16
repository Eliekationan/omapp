<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\User;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    // 
    public function getContribution(Request $request){
        $year = $request->year;
        if(empty($year)){
            return ['is_success'=>false, "message"=>"Veuillez Spécifier l'année"];

        }
        // $users = User::with("contributions")->paginate(10);
        $contributions = User::with(['contributions' => function ($query) use ($year) {
            $query->where('year', $year);
        }])->paginate(10);
        // dd($users);
        return ['is_success'=>true, "contribs"=>$contributions];
    }
    public function updateOneContribution(Request $request){
        $user_id = $request->user_id;
        $amount = $request->amount;
        $month = $request->month;
        $year = $request->year;

        if(empty($user_id)){
            return ["is_sucess"=>false, "error_message"=>"User id: Expected number and null given"];
        }
        if(empty($month) || empty($year)){
            return ["is_sucess"=>false, "error_message"=>"Month: Expected number and null given"];
        }

        if(empty($amount)){
            $contrib = new Contribution();
            // dd($contrib);
            $contrib->amount = env("AMOUNT");
            $contrib->month = $month;
            $contrib->user_id = $user_id;
            $contrib->year = $year;
            $contrib->save();
            return ["is_success"=>true, "message"=>"Operation effectuée avec succès"];
        }
        else{

        }
    }
    public function searchContribution(Request $request){
        $year = $request->year;
        $keyword = $request->keyword;
        if(empty($year)){
            return ['is_success'=>false, "message"=>"Veuillez Spécifier l'année"];

        }
        // $users = User::with("contributions")->paginate(10);
        $contributions = User::with(['contributions' => function ($query) use ($year) {
            $query->where('year', $year);
        }])->where('name', 'like', "%$keyword%")
            ->orWhere('second_name', 'like', "%$keyword%")
            ->orWhere('birth_date', 'like', "%$keyword%")
            ->orWhere('adresse', 'like', "%$keyword%")
            ->paginate(10);
        // dd($contributions);
        return ['is_success'=>true, "contribs"=>$contributions];
    }
    public function getTotalPerYear(Request $request){
        $year = $request->year; 
        $contrib = Contribution::where('year', $year)->count();
        $totalAmount = $contrib * env("AMOUNT");
        return ['is_success'=>true, 'nbContrib'=>$contrib, "totalAmount"=> $totalAmount];
    }

    public function getContribForUser(Request $request){
        $year = $request->year;
        $user_id = $request->user_id;
        if(empty($year) || empty($user_id)){
            return ['is_success'=>false, "message"=>"Veuillez Spécifier l'année ou l'utilsateur"];
        }
        // $user = User::find($user_id);
        // dd($user);
        $contribution = User::with(['contributions' => function ($query) use ($year) {
            $query->where('year', $year);
        }])->find($user_id);

        return ['is_success'=>true, "contribs"=>$contribution];
    }
}
