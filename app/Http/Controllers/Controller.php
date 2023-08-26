<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
    }
    public function beginTransaction()
    {
        return DB::beginTransaction();
    }
    public function commitTransaction()
    {
        return DB::commit();
    }
    public function rollbackTransaction()
    {
        return DB::rollback();
    }
    public function dataRequest(Request $request)
    {
        return array_filter($request->input());
    }
    public function imageRequest(\Illuminate\Http\Request $request, $img = 'img_url')
    {
        $data = $this->dataRequest($request);
        return isset($data[$img]) ? $data[$img] : '';
    }
    public function randomString(int $count)
    {
        return \Illuminate\Support\Str::random($count);
    }
    public function slug(Model $model, $data)
    {
        if($result = $model::where('slug', $data)->doesntExist()){
            return $data;
        }
        $i = 1;
        do {
            if ($model::where('slug', $data . '_' . $i)->doesntExist()) {
                return $data . '_' . $i;
            }
            $i++;
        } while (true);
    }
}
