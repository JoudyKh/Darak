<?php

namespace App\Http\Controllers;

use App\Http\Requests\Property\CreatePropertyRequest;
use App\Http\Requests\Property\UpdatePropertyRequest;
use App\Models\P_sections;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index( $section, Request $request){
        $query = Property::query();
        if($section == 'search'){
            if($request->search != 'null'){
                foreach(Property::$searchable as $item){
                    $query->orWhere($item,$request->search);
                }
            }
            if($request->best == 1)
                $query->where('is_best', 1);
            if($request->price_from != 'null' && $request->price_to != 'null')
                $query->whereBetween('total_price',[$request->price_from , $request->price_to]);
            if($request->region != 'null') 
                $query->where('address', $request->region);
            if($request->space != 'null') 
                $query->where('area', $request->space);
            $properties = $query->with('images')->paginate(config('app.pagination_limit'));
    
            return success($properties);
        }
        if($section =='best'){
            return success(Property::with('images')->where('is_best', 1)->take(15)->get());
        }
        $section = P_sections::findOrFail($section);
        return success($section->properties()->with('images')->get(),200,['section'=>$section]);
    }

    public function map()
    {
        $properties = Property::pluck('longitude','latitude')->toArray();
        foreach ($properties as $latitude => $longitude) {
            $response[] = [
                'lat' => $latitude,
                'long' => $longitude
            ];
        }
        return success($response);
        
    }
      
    public function show(Property $property)
    {
        return success($property,200,['images'=>$property->images]);
    }
    public function create(CreatePropertyRequest $request, P_sections $section)
    {
        $data = $request->validated();
        $property =$section->properties()->create($data);
        foreach ($request->file('files') as $image) {
            $path = $image->store('property/images', 'public');
            $fileInfo = pathinfo($path);
            $type = strtolower($fileInfo['extension']);
            $property->images()->create(['file'=>$path, 'type'=>$type]);
        }
        return success($property,200,['images'=>$property->images]);
    }
    public function update(UpdatePropertyRequest $request, P_sections $section, Property $property)
    {
        $data = $request->validated();
        $data = $request->except('_method');
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $image) {
                $path = $image->store('property/images', 'public');
                $fileInfo = pathinfo($path);
                $type = strtolower($fileInfo['extension']);
                $property->images()->create(['file'=>$path, 'type'=>$type]);
            }
        }
        if($request->has('trashed_files')){
            if(count($request->trashed_files) >= $property->images()->count()){
                return error(['message'=>'can not delete all files','',422]);
            }
            else{
                foreach ($request->trashed_files as $fileId) {
                    $image = $property->images()->findOrFail($fileId);
                    Storage::disk('public')->delete($image->file);
                    $image->delete();
                }
            }
        }
        $data['section_id'] = $section->id;
        $property->update($data);
        return success($property,200,['images'=>$property->images]);
    }
    public function destroy(Property $property)
    {
        $property->delete();
        return success();
    }

    public function regions()
    {
        $regions = Property::distinct('address')->pluck('address');
        $transformedRegions = $regions->map(function ($region) {
            return ['name' => $region];
        });
        
        return success($transformedRegions);
    }
}
