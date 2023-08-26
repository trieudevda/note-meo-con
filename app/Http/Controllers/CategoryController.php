<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function list()
    {
        $categories = Category::all();
        return response()->json(['category' => $categories]);
    }
    public function search(){}

    public function detail($id)
    {
        $check= Category::findOrFail($id);
        if(!$check) return response()->json(['status'=>'fail','msg'=>'No data category']);
        $data=Category::find($id);
        return response()->json(['status'=>'success','msg'=>'', 'data' =>$data]);
    }
    public function update(Request $request,$id)
    {
        $check= Category::findOrFail($id);
        if(!$check) return response()->json(['status'=>'fail','msg'=>'No data category']);
        $data=$this->dataRequest($request);
        $this->beginTransaction();
        try{
            if(isset($data['slug'])){
                $data['slug'] = $this->slug(new Category(), $data['slug']);
            }
            Category::where('id',$id)->update($data);
            $this->commitTransaction();
            return response()->json(['status'=>'success','msg'=>'Update data category']);
        }catch(\Exception $e){
            $this->rollbackTransaction();
            return response()->json(['status'=>'fail','msg'=>'update category fail '.$e->getMessage()]);
        }
    }
    public function create(Request $request)
    {
        $this->beginTransaction();
        try {
            $data = $this->dataRequest($request);
            $data['slug'] = $this->slug(new Category(), $data[ isset( $data['slug']) && $data['slug']!='' ? 'slug' : 'name' ]);
            Category::create($data);
            $this->commitTransaction();
            return response()->json(['status' => 'success', 'msg' => 'create success']);
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            return response()->json(['status' => 'fail', 'msg' => 'create failed ' . $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        $check= Category::findOrFail($id);
        if(!$check) return response()->json(['status'=>'fail','msg'=>'data not exist']);
        $this->beginTransaction();
        try{
            Category::where('id',$id)->delete();
            $this->commitTransaction();
            return response()->json(['status'=>'success','msg'=>'Delete data category']);
        }catch(\Exception $e){
            $this->rollbackTransaction();
            return response()->json(['status'=>'fail','msg'=>'delete category fail '.$e->getMessage()]);
        }
    }
}
