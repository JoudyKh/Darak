<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\CreateServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Ser_sections;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index( $section ,Request $request)
    {
        $services=Service::query();
        if($section == 'search'){
            foreach(Service::$searchable as $item){
                $services->orWhere($item,$request->search)->with('images');
            }
            return success($services->paginate(config('app.pagination_limit')));
        }
        $section = Ser_sections::findOrFail($section);
        $services = $section->services()->with('images')->paginate(config('app.pagination_limit'));
        return success($services, 200,['section'=>$section,'total'=>count($services)]);
    }
    public function show(Service $service)
    {
        return success($service,200,['images'=>$service->images]);
    }
    public function create(CreateServiceRequest $request, Ser_sections $section)
    {
        $data = $request->validated();
        $service =$section->services()->create($data);
        foreach ($request->file('files') as $image) {
            $path = $image->store('service/images', 'public');
            $fileInfo = pathinfo($path);
            $type = strtolower($fileInfo['extension']);
            $service->images()->create(['file'=>$path, 'type'=>$type]);
        }
        return success($service,200,['images'=>$service->images]);
    }
    public function update(UpdateServiceRequest $request, Ser_sections $section, Service $service)
    {
        $data = $request->validated();
        $data = $request->except('_method');
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $image) {
                $path = $image->store('service/images', 'public');
                $fileInfo = pathinfo($path);
                $type = strtolower($fileInfo['extension']);
                $service->images()->create(['file'=>$path, 'type'=>$type]);
            }
        }
        if($request->has('trashed_files')){
            if(count($request->trashed_files) >= $service->images()->count()){
                return error(['message'=>'can not delete all files','',422]);
            }
            else{
                foreach ($request->trashed_files as $fileId) {
                    $image = $service->images()->findOrFail($fileId);
                    Storage::disk('public')->delete($image->file);
                    $image->delete();
                }
            }
        }
        $data['section_id'] = $section->id;
        $service->update($data);
        return success($service,200,['images'=>$service->images]);
    }
    public function destroy(Service $service)
    {
        $service->delete();
        return success();
    }
  }
