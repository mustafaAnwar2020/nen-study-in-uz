<?php

namespace App\Http\Controllers\Api;

use App\Models\EduAdministration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AjaxController extends Controller
{

    public function get_cities(Request $request)
    {
        // fetch all
        $data = DB::table('cities')
            ->where('governorate_id', $request->governorate_id)
            ->get();

      /*  if ($request->address_assets == "true") { // fetch only active
            $data = DB::table('cities')
                ->where(['governorate_id' => $request->governorate_id, 'is_active' => true])
                ->get();
        }*/

        return response()->json($data);
    }


    public function get_villages(Request $request)
    {
        $data = DB::table('villages')
            ->where(['city_id' => $request->city_id, 'is_active' => true])
            ->get();
        return response()->json($data);
    }

    public function get_edu_admins(Request $request)
    {
        $data = EduAdministration::where('governorate_id', $request->governorate_id)
            ->get();
        return response()->json($data);
    }


    public function getNews(Request $request)
    {
        $data = config('news');
        return response()->json($data);
    }


}
