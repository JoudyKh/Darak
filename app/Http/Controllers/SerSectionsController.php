<?php

namespace App\Http\Controllers;

use App\Http\Requests\Section\CreateSectionRequest;
use App\Http\Requests\Section\UpdateSectionRequest;
use App\Models\Ser_sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SerSectionsController extends Controller
{
    public function index(Request $request)
    {
        $sections = Ser_sections::query();
        if($request->search != null ){
            foreach(Ser_sections::$searchable as $item){
                $sections->orWhere($item,$request->search);
            }
            return success($sections->paginate(config('app.pagination_limit')));
        }
        else{
        $sections = Ser_sections::paginate(config('app.pagination_limit'));
        return success($sections);
        }
    }
    public function show(Ser_sections $section)
    {
        return success($section);
    }
    public function create(CreateSectionRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('ser_sections/images', 'public');
        $section = Ser_sections::create($data);
        return success($section);
    }
    public function update(UpdateSectionRequest $request, Ser_sections $section)
    {
        $data = $request->validated();
        $data = $request->except('_method');
        if ($request->hasFile('image')) {       
            Storage::disk('public')->delete($section->image);
            $data['image'] = $request->file('image')->storePublicly('ser_sections/images', 'public');
        }
        $section->update($data);
        return success($section);
    }
    public function destroy(Ser_sections $section)
    {
        $section->delete();
        return success();
    }
}
