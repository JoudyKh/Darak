<?php

namespace App\Http\Controllers;

use App\Http\Requests\Info\CreateInfoRequest;
use App\Http\Requests\Info\UpdateInfoRequest;
use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::pluck( 'value','key');
        return success($infos);
    }
    public function show(Info $info)
    {
        return success($info);
    }
    public function create(CreateInfoRequest $request)
    {

        $data = $request->validated();
        $info = Info::create($data);
        return success($info);
    }
    public function update(UpdateInfoRequest $request,$key)
    {
        $data = $request->validated();
        $info = Info::where('key', $key)->first();
        $info->update($data);
        return success($info);
    }
    public function destroy( $key)
    {
        $info = Info::where('key', $key)->first();
        $info->delete();
        return success();
    }
}
