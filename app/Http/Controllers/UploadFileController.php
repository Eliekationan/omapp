<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UploadFile;

class UploadFileController extends Controller
{
    //
    public function uploadFile(Request $request){
        $custom_messages = [
            'file_name.required' => "Veuillez renseigner le nom du fichier",
            'file_url.required' => "Veuillez uploader un fichier",
            'file_url.mimes' => "Veuillez uploader un fichier images(jpg, png, jpeg, JPG, PNG, JPEG) ou pdf ou doc ou docx ou xlsx",
            'user_id.required' => "Veuillez spécifier l'id de l'utilisateur",
        ];

        $rules = [
            'user_id' => 'required',
            'file_name' => 'required',
            'file_url' => 'required|mimes:jpg,png,jpeg,pdf,PDF,JPG,PNG,JPEG,doc,DOC,docx,DOCX,xlsx,XLSX,xls,XLS,pptx,PPTX,ppt,PPT|max:512099895',
            'file_ext' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);

        if ($validator->fails()) {
            return ['statut' => 400, 'message' => $validator->errors()->first(), 'data' => NULL];
        }
        // dd($file_url = $request->file('file_url'));
        $file_url = $request->file('file_url')->store("images/phototheques", 'public');
        $data=UploadFile::create([
            "file_name"=>$request->file_name,
            "description"=>$request->description,
            "file_url"=>$file_url,
            "file_ext"=>$request->file_ext,
            "upload_by"=>$request->user_id,
        ]);

        return ['is_sucess'=>true, "files"=>$data];
    }
    public function getFiles(Request $request){
        $custom_messages = [
            'user_id.required' => "Veuillez spécifier l'id de l'utilisateur",
        ];

        $rules = [
            'user_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_messages);

        if ($validator->fails()) {
            return ['statut' => 400, 'message' => $validator->errors()->first(), 'data' => NULL];
        }
        $data = UploadFile::where('upload_by', $request->user_id)->get();
        return ['is_sucess'=>true, "files"=>$data];
    }
}
