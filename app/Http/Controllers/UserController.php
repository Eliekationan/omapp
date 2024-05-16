<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Adhesion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{
    protected static ?string $password;
    public function storeUser(Request $request){
        $rules = [
            "name" => 'required',
            "second_name" => 'required',
            "email" => 'required|unique:users,email',
            "domicile" => 'required',
            // "telephone" => 'required'
        ];
        $custom_messages = [
            'name.required' => "Veuillez renseigner le nom",
            'email.required' => "Veuillez renseigner l'adresse mail",
            'email.unique' => "Cette adresse mail est déjà utilisée",
            'domicile.required' => "Veuillez renseigner votre lieu d'habitation",
            // 'telephone.required' => "Veuillez renseigner le telephone"
        ];
        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return ['is_success'=>false,'status' => 500, 'message' => $validator->errors()->first()];
        }
        $a = $this->storeUserF($request);
        if($a){
            return ["is_success"=>true, "message"=>"Utilisateur sauvegardé avec succès"];
        }
        else{
            return ["is_success"=>false, "message"=>"Une erreur s'est produite. L(utilisateur n'a pas pu être sauvegardé"];
        }

    }
    public function getUsers(){
        // $users = DB::table('users')->paginate(10);
        $users = User::with('roles')
        ->orderBy('id', "desc")
        ->paginate(10);
        // dd($users[0]->roles);
        return $users;
    }
    public function getRoles(){
        $roles = Role::orderBy('id', "desc")->paginate(10);
        return $roles;
    }
    public function updateUser(Request $request){

        $birth_date = $request->birth_date;
        $domicile = $request->domicile;
        $email = $request->email;
        $grade = $request->grade;
        $fonction = $request->fonction;
        $name = $request->name;
        $nature_piece = $request->nature_piece;
        $numero_piece = $request->numero_piece;
        $retraite = $request->retraite;
        $second_name = $request->second_name;
        $secteur_activite = $request->secteur_activite;
        $telephone = $request->phone;
        $ville = $request->ville;
        $role = Role::where("role_name", "Membre")->first();
        
        $userVille = DB::table("cities")->where("city", "=", $ville)->first();
        $array = [
            "birth_date" => $birth_date,
            "adresse" => $domicile,
            "email" => $email,
            "grade" => $grade,
            "name" => $name,
            "nature_piece" => $nature_piece,
            "numero_piece" => $numero_piece,
            "fonction" => $fonction,
            "grade" => $grade,
            "retraite" => $retraite,
            "second_name" => $second_name,
            "city_id" => $userVille->id,
            "secteur_activite" => $secteur_activite,
            "telephone" => $telephone,
        ];

        DB::table("users")
                    ->where("id", $request->id)
                    ->update($array);
        
        try {
            //code...
            DB::table("role_user")
                ->where("user_id", $request->id)
                ->update([
                'role_id' => $role->id,
                "user_id" => $request->id,
                "active" => "true"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return ["is_success"=>true, "message"=>"Mise à jour de l'utilisateur effectué avec succès"];
    }
    public function updateCredentials(Request $request){
        $user_id = $request->id;
        $confirmPasswordHashed = static::$password ??=  Hash::make($request->confirmPassword);
        $user = User::find($user_id);
        if($request->newPassword != $request->confirmPassword){
            return ["is_success"=>false, "message"=>"Les mots de passes sont differents"];
        }
        if(!Hash::check($request->password, $user->password)){
            return ["is_success"=>false, "message"=>"Le mot de passe n'est pas correcte"];
        }

        $user->password = $confirmPasswordHashed;
        
        $user->save();

        return ["is_success"=>true, "message"=>"Mise à jour du mot de passe effectué avec succès"];

    }
    public function softDelete(Request $request){
        $user = User::find($request->id);
        $user->delete();
        return ['is_success'=>true, "message"=>"Utilisateur supprimé avec succès"];
    }

    public function storeRole(Request $request){
        $role_name = $request->role_name;
        $description = $request->description;

        $rules = [
            "role_name" => 'required',
        ];
        $custom_messages = [
            'role_name.required' => "Veuillez renseigner l'intitulé du role que vous voulez créer",
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return ['is_success'=>false,'status' => 500, 'message' => $validator->errors()->first()];
        }

        $uuid = Str::uuid();
        $role = new Role();
        $role->role_name = $role_name;
        $role->description = $description;
        $role->role_uuid = $uuid;

        $role->save();

        return ["is_success"=>true, "message"=>"Role sauvegardé avec succès"];
    }
    public function updateRole(Request $request){
        $role_name = $request->role_name;
        $description = $request->description;

        $rules = [
            "role_name" => 'required',
        ];
        $custom_messages = [
            'role_name.required' => "Veuillez renseigner l'intitulé du role que vous voulez créer",
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return ['is_success'=>false,'status' => 500, 'message' => $validator->errors()->first()];
        }

        $role = Role::find($request->id);
        $role->update([
           "role_name" => $role_name,
            "description" => $description,
        ]);
        return ["is_success"=>true, "message"=>"Role sauvegardé avec succès"];
    }
    public function softDeleteRole(Request $request){
        $role = Role::find($request->id);
        $role->delete();
        return ['is_success'=>true, "message"=>"Rôle supprimé avec succès"];
    }
    public function adhesionList(){
        // $users = DB::table('users')->paginate(10);
        $adh = Adhesion::orderBy('id', "desc")
                            ->paginate(10);
        return $adh;
    }
    public function migrationProcesssing(Request $request){
        // find user into adhesions tables
        $rules = [
            "id" => 'required',
        ];
        $custom_messages = [
            'id.required' => "Veuillez spécifier un adhérant",
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return ['is_success'=>false,'status' => 500, 'message' => $validator->errors()->first()];
        }

        $adh = Adhesion::find($request->id);
        if(empty($adh)){
            return ['is_success'=>false, "message"=>"utilisateur introuvable", 'code_error'=>'NOT_FOUND'];
        }
        // validation des attribut avant migrations dans la table users
        if(empty($adh->name)){
            return ['is_success'=>false, 'message'=>"Veuillez preciser le nom de l'utilisateur", 'code_error'=>'ATT_MISSING', "attribut"=>"Nom"];
        }
        if(empty($adh->second_name)){
            return ['is_success'=>false, 'message'=>"Veuillez preciser le prenom de l'utilisateur", 'code_error'=>'ATT_MISSING', "attribut"=>"Prenom"];
        }
        if(empty($adh->email)){
            return ['is_success'=>false, 'message'=>"Veuillez preciser l'email de l'utilisateur", 'code_error'=>'ATT_MISSING', "attribut"=>"Email"];
        }
        if(empty($adh->adresse)){
            return ['is_success'=>false, 'message'=>"Veuillez preciser le domicile de l'utilisateur", 'code_error'=>'ATT_MISSING', "attribut"=>"Domicile"];
        }
        try {
            $res = $this->storeUserF($adh);
            if ($res){
                return ["is_success"=>true, "message"=>"Utilisateur sauvegardé avec succès"];
            }
        } catch (Exception $e) {
            $errCode = $e->getCode();
            $error = "Une erreur est survenue: " . $e->getCode(); 
            if($errCode == 23000){
                $error = "Cette adresse mail est déjà utilisée";
            }

            return ["is_success"=>false, "message"=>$error];
        }
        
    }
    public function storeUserF($request){
        $birth_date = $request->birth_date;
        $domicile = $request->domicile ?? $request->adresse;
        $email = $request->email;
        $grade = $request->grade;
        $fonction = $request->fonction;
        $name = $request->name;
        $nature_piece = $request->nature_piece;
        $numero_piece = $request->numero_piece;
        $retraite = $request->retraite;
        $second_name = $request->second_name;
        $secteur_activite = $request->secteur_activite;
        $telephone = $request->phone;
        $ville = $request->ville;
        
        $role = Role::where("role_name", "Membre")->first();
        
        $userVille = DB::table("cities")->where("city", "=", $ville)->first();
        $user = new User();
        $user->birth_date = $birth_date;
        $user->adresse = $domicile;
        $user->email = $email;
        $user->grade = $grade;
        $user->name = $name;
        $user->nature_piece = $nature_piece;
        $user->numero_piece = $numero_piece;
        $user->fonction = $fonction;
        $user->grade = $grade;
        $user->retraite = $retraite;
        $user->second_name = $second_name;
        $user->city_id = $userVille?->id;
        $user->secteur_activite = $secteur_activite;
        $user->telephone = $telephone;
        $user->password = static::$password ??= Hash::make('password');
        $user->save();
        
        try {
            //code...
            DB::table("role_user")->insert([
                'role_id' => $role->id,
                "user_id" => $user->id,
                "active" =>"true"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return true;
    }
}
