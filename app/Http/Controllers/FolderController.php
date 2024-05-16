<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    public function createFolder(Request $request){
        $default_folder_name = "Nouveau dossier";
        $nb_folders = Folder::where("folder_name", "like", $default_folder_name ."%")->count();
        if ($nb_folders > 0){
            $default_folder_name = $default_folder_name . (string) $nb_folders;
        }
        $newFolder = Folder::create([
            'folder_name' => $request->folder_name ?? $default_folder_name,
            'description' => $request->description ?? "Double cliquer pour mettre la description",
            'created_by' => $request->user_id,
            'mark_as_favorite' => false,
        ]);

        return ["is_success"=>true, "newFolder"=>$newFolder];
    }
    public function getFolders(Request $request){
        $folders = Folder::orderBy('id', "desc")->get();
        return ["is_success"=>true, "folders"=>$folders];
    }
    public function deleteFolder(Request $request){
        $folder_id = $request->folder_id;
        $user_id = $request->user_id;
        $rules = [
            "user_id" => 'required',
            "folder_id" => 'required',
            
        ];
        $custom_messages = [
            'user_id.required' => "Veuillez renseigner le nom",
            'folder_id.required' => "Veuillez renseigner l'adresse mail",
            // 'telephone.required' => "Veuillez renseigner le telephone"
        ];
        $validator = Validator::make($request->all(), $rules, $custom_messages);
        if ($validator->fails()) {
            return ['is_success'=>false,'status' => 500, 'message' => $validator->errors()->first()];
        }
        Folder::find($folder_id)->delete();
        return ["is_success"=>true, "message"=>"Dossier supprimer avec succès"];
    }
    public function renameFolder(Request $request){
        $folder_name = $request->folder_name;
        $folder_id = $request->id;
        $created_by = $request->created_by;
        $user_id = $request->user_id;
       
        if($created_by != $user_id){
            return ["is_success"=> false, "message"=>"Vous ne pouvez pas renommer ce dossier"];
        }
        $folder = Folder::find($folder_id);
        $folder->folder_name = $folder_name;
        $folder->save();
        return ["is_success" =>true, "message"=>"Fichier renommer avec succès"];
    }
    public function getFiles(Request $request){
        $folder_id = $request->folder_id;
        $files = File::where("folder_id", $folder_id)->orderBy('id', "desc")->get();
        return ["is_success" =>true, "files"=>$files];
    }
    public function addFile(Request $request){
        $custom_messages = [
            'folder_id.required' => "Veuillez choisir un dossier",
            'file_name.required' => "Veuillez renseigner le nom du fichier",
            'file_url.required' => "Veuillez uploader un fichier",
            'file_url.mimes' => "Veuillez uploader un fichier images(jpg, png, jpeg, JPG, PNG, JPEG) ou pdf ou doc ou docx ou xlsx",
            'upload_by.required' => "Veuillez spécifier l'id de l'utilisateur",
        ];

        $rules = [
            'folder_id' => 'required',
            'file_name' => 'required',
            'file_url' => 'required|mimes:jpg,png,jpeg,pdf,PDF,JPG,PNG,JPEG,doc,DOC,docx,DOCX,xlsx,XLSX,xls,XLS,pptx,PPTX,ppt,PPT|max:512099895',
            'file_ext' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);

        if ($validator->fails()) {
            return ['statut' => 400, 'message' => $validator->errors()->first(), 'data' => NULL];
        }
        // dd($file_url = $request->file('file_url'));
        $file_url = $request->file('file_url')->store("files", 'public');
        $data=File::create([
            "folder_id"=>$request->folder_id,
            "file_name"=>$request->file_name,
            "description"=>$request->description,
            "file_url"=>$file_url,
            "mark_as_favorite"=>false,
            "file_ext"=>$request->file_ext,
            "upload_by"=>$request->upload_by,
        ]);

        return ['is_sucess'=>true, "files"=>$data];
    }
    public function shareFile(Request $request){
        $file_id = $request->id;
        $file = File::find($file_id);
        $file->shared = true;
        $file->save();
        return ['is_sucess'=>true, "message"=>"Publication de fichier terminé"];
    }
}
