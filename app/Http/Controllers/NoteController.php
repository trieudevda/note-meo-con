<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }
    public function list()
    {
        $note = Note::with('category')->get();
        return response()->json(['note' => $note]);
    }
    public function search($id){
        $note = Note::where('id',$id)->with('category')->first();
        return response()->json(['note' => $note]);
    }
    public function detail($id)
    {
        $check= Note::findOrFail($id);
        if(!$check) return response()->json(['status'=>'fail','msg'=>'No data note']);
        $data=Note::find($id);
        return response()->json(['status'=>'success','msg'=>'', 'data' =>$data]);
    }
    public function update(Request $request,$id)
    {
        $check= Note::findOrFail($id);
        if(!$check) return response()->json(['status'=>'fail','msg'=>'No data note']);
        $data=$this->dataRequest($request);
        $this->beginTransaction();
        try{
            Note::where('id',$id)->update($data);
            $this->commitTransaction();
            return response()->json(['status'=>'success','msg'=>'Update data note']);
        }catch(\Exception $e){
            $this->rollbackTransaction();
            return response()->json(['status'=>'fail','msg'=>'update note fail '.$e->getMessage()]);
        }
    }
    public function create(Request $request)
    {
        $this->beginTransaction();
        try {
            $data = $this->dataRequest($request);
            Note::create($data);
            $this->commitTransaction();
            return response()->json(['status' => 'success', 'msg' => 'create success']);
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            return response()->json(['status' => 'fail', 'msg' => 'create failed ' . $e->getMessage(),'data'=>$request->input()]);
        }
    }
    public function delete($id)
    {
        $check= Note::findOrFail($id);
        if(!$check) return response()->json(['status'=>'fail','msg'=>'data not exist']);
        $this->beginTransaction();
        try{
            Note::where('id',$id)->delete();
            $this->commitTransaction();
            return response()->json(['status'=>'success','msg'=>'Delete data note']);
        }catch(\Exception $e){
            $this->rollbackTransaction();
            return response()->json(['status'=>'fail','msg'=>'delete note fail '.$e->getMessage()]);
        }
    }
}
