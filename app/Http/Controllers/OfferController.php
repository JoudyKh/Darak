<?php

namespace App\Http\Controllers;

use App\Http\Requests\Offer\CreateOfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{

    public function index()
    {
        $offers = Offer::paginate(config('app.pagination_limit'));
        $total = Offer::select('id')->get()->count();
        return success($offers,200,['total'=>$total]);
    }
    public function show(Offer $offer)
    {
        return success($offer);
    }
    public function create(CreateOfferRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('offer/images', 'public');
        $offer = Offer::create($data);
        return success($offer);
    }
    public function update(Request $request, Offer $offer)
    {
        $data = $request->except('_method');
        if ($request->hasFile('image')) {       
            Storage::disk('public')->delete($offer->image);
            $data['image'] = $request->file('image')->storePublicly('offer/images', 'public');
        }
        $offer->update($data);
        return success($offer);
    }
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return success();
    }
}
