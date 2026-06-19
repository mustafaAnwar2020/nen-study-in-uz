<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $model = 'بيانات المستخدمين تحتاح إلي تعديل';

        $ids = User::role('student')
            ->select('id_number', 'id', DB::raw('count(`id_number`) as occurences'))
            ->groupBy('id_number')
            ->having('occurences', '>', 1)
            ->pluck('id_number');

        $rows = User::role('student')
            ->with('application', 'governorate', 'city')
            ->whereIn('id_number', $ids)
            ->when($request->city_id, function ($query) use ($request) {
                return $query->where('address_city_id', $request->city_id);
            })
            ->orderBy('id_number')
            ->paginate(60);

        return view('admin.data.index', get_defined_vars());
    }


    public function delete(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            History::makeHistory(currentUser(),
                'User',
                'delete_duplicate_id_number',
            );
            $user->groups()->detach();
            $user->delete();
        }
        return response()->json(true);
    }


    public function others()
    {
        $model = 'بيانات المستخدمين تحتاح إلي تعديل';

        $idLessThan14 = User::role('student')
            ->with('application', 'governorate', 'city', 'groups')
            ->whereRaw('LENGTH(id_number) < 14')->get();

        $idMoreThan14 = User::role('student')
            ->with('application', 'governorate', 'city', 'groups')
            ->whereRaw('LENGTH(id_number) > 14')->get();

        $idIsNull = User::role('student')
            ->with('application', 'governorate', 'city', 'groups')
            ->whereNull('id_number')->paginate(50);

        return view('admin.data.others', get_defined_vars());
    }


    public function gender()
    {
        $model = 'الملتحقين بدون تحديد النوع';
        $userIds = DB::table('group_user')->pluck('user_id');
        $rows = User::whereIn('id', $userIds)->role('student')->whereNull('gender')->paginate(50);
        return view('admin.data.gender', get_defined_vars());
    }
}
