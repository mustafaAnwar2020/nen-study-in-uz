<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Governorate;
use App\Models\History;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;

class SetLocationController extends Controller
{
    public function index()
    {
        $model = 'إعدادت المواقع';
        $governorates = Governorate::all();
        return view('admin.settings.locations.index', get_defined_vars());
    }

    public function show_sub(Governorate $governorate) // get cities and villages from governorate
    {
        $cities = $governorate->cities;
        $cities_ids = $governorate->cities()->pluck('id');

        $villages = Village::whereIn('city_id', $cities_ids)->get();
        $model = $governorate->governorate_name_ar;

        return view('admin.settings.locations.show_sub', get_defined_vars());
    }


    public function storeCity(Request $request, Governorate $governorate)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        $governorate->cities()->create([
            'city_name_ar' => $request->name_ar,
            'city_name_en' => $request->name_en,
        ]);

        History::makeHistory(auth()->user(),
            'Locations',
            'storeCity'
        );

        return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
    }


    public function showVillages(City $city)
    {
        $villages = $city->villages;
        $gov = $city->governorate->governorate_name_ar;
        $model = $city->city_name_ar;

        return view('admin.settings.locations.show_villages', get_defined_vars());
    }


    public function storeVillage(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $city->villages()->create([
            'name' => $request->name,
        ]);

        History::makeHistory(auth()->user(),
            'Locations',
            'storeVillage'
        );

        return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
    }


    public function deleteVillage(Village $village)
    {
        if (User::where('address_village_id', $village->id)->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف هذه القرية لوجود مستخدمين مسجلين بها');
        }

        $village->delete();

        History::makeHistory(auth()->user(),
            'Locations',
            'deleteVillage'
        );

        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }


    public function update_status(Request $request)
    {
        if ($request->type == 'gov') {
            $row = Governorate::find($request->id);
            $row->is_active = !$row->is_active;
            $row->save();
        }

        if ($request->type == 'city') {
            $row = City::find($request->id);
            $row->is_active = !$row->is_active;
            $row->save();
        }

        if ($request->type == 'village') {
            $row = Village::find($request->id);
            $row->is_active = !$row->is_active;
            $row->save();
        }

        History::makeHistory(auth()->user(),
            'Locations',
            'update_status'
        );
        return response()->json('success');
    }
}
