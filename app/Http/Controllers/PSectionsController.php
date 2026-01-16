<?php

namespace App\Http\Controllers;

use App\Http\Requests\PSection\CreatePSectionRequest;
use App\Http\Requests\PSection\UpdatePSectionRequest;
use App\Models\P_sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PSectionsController extends Controller
{
    public function index(Request $request)
    {  
        $sections = P_sections::query();
        if($request->search != null){
            foreach(P_sections::$searchable as $item){
              $sections->orWhere($item, $request->search);
            }
            return success($sections->paginate(config('app.pagination_limit')));
        }
        $sections = P_sections::paginate(config('app.pagination_limit'));
        return success($sections);
    }
    public function show(P_sections $section)
    {
        return success($section);
    }
    public function create(CreatePSectionRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('p_sections/images', 'public');
        $section = P_sections::create($data);
        return success($section);
    }
    public function update(UpdatePSectionRequest $request, P_sections $section)
    {
        $data = $request->validated();
        $data = $request->except('_method');
        if ($request->hasFile('image')) {       
            Storage::disk('public')->delete($section->image);
            $data['image'] = $request->file('image')->storePublicly('p_sections/images', 'public');
        }
        $section->update($data);
        return success($section);
    }
    public function destroy(P_sections $section)
    {
        $section->delete();
        return success();
    }
}
