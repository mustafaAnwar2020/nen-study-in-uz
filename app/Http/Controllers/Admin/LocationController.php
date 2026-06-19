<?php

namespace App\Http\Controllers\Admin;

use App\Models\History;
use App\Models\Location;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    use CommonTrait;

    public function index(Request $request)
    {
        $rows = Location::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        $rows = $rows->paginate(20);
        $model = 'Locations';
        return view('admin.locations.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Locations';
        return view('admin.locations.manage', get_defined_vars());
    }


    public function edit($slug)
    {
        $row = Location::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit location - ' . $row->name;
        return view('admin.locations.manage', get_defined_vars());
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location_type' => 'required|in:Main Offices,Authorized Offices',
            'country_code' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'description' => 'nullable|string',
            'land_line' => 'nullable|string',
            'call_center' => 'nullable|string',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'map_url' => 'nullable|string',
            'schedule' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        if ($request->map_url) {
            $coordinates = getCoordinatesFromGoogleMapsUrl($request->map_url);
            if (!$coordinates) {
                return redirect()->back()->with('error', 'Invalid map url you need to check url has @ symbol');
            }
            $data['latitude'] = $coordinates['latitude'];
            $data['longitude'] = $coordinates['longitude'];
        }

        // Check if it's an update request
        $isUpdate = $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $image = null;
        if ($isUpdate) {
            $oldRow = Location::find($request->row_id);
            $image = $oldRow->image;

            if ($request->image) {
                $this->deleteOldFile($image);
            }

            $data['slug'] = $oldRow->slug;
        } else {
            $data['slug'] = Location::generateSlug();
        }

        if ($request->image) {
            $image = $request->image;
        }

        $data['image'] = $image;
        $location = Location::query()->updateOrCreate(['id' => $request->row_id], $data);

        History::makeHistory(auth()->user(),
            'Location',
            'create',
            $location->id
        );

        return redirect()->route('admin.locations.index')->with('success', $status);
    }


}
