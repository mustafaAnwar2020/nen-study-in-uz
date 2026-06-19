<?php
namespace App\Http\Controllers\Admin;
use App\Exports\ReportGroupStudentDetailsExport;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Governorate;
use App\Models\History;
use App\Models\User;
use App\Traits\CommonTrait;
use App\Traits\ReportsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportReportController extends Controller
{
    use CommonTrait, ReportsTrait;

    public function index()
    {
        $model = 'تصدير التقارير';
        return view('admin.export_reports.index', get_defined_vars());
    }

    public function groupsReport(Request $request)
    {
        $this->validate($request, [
            'period_id' => 'required',
            'course_id' => 'required',
            'city_id' => 'required',
        ]);

        $period = Period::find($request->period_id);
        $course = Course::find($request->course_id);

        if (!$course || !$period)
            return back()->with('error', 'معلومات غير صحيحية');

        $data = Group::where('is_active', 1)->with('students', 'city', 'period')
            ->where('period_id', $request->period_id)
            ->where('course_id', $request->course_id)
            ->where('city_id', $request->city_id)
            ->get();

        History::makeHistory(currentUser(),
            'Report',
            'export_groups_report',
        );
        return Excel::download(new PeriodGroupExport($data, $period, $course, $request->cols), 'تقرير_المجموعات_التفصيلي_للمرحلة' . str_replace("/", "-", $period->name) . time() . '.xlsx');
    }


    public function courseExport(Request $request)
    {
        $this->validate($request, [
            'period_id' => 'required',
            'course_id' => 'required',
        ]);

        $period = Period::find($request->period_id);
        $course = Course::find($request->course_id);

        if (!$course || !$period)
            return back()->with('error', 'معلومات غير صحيحية');

        $groups = Group::where('period_id', $request->period_id)
            ->where('course_id', $request->course_id)
            ->where('is_active', 1);
        $userIds = DB::table('group_user')->whereIn('group_id', $groups->pluck('id'))->pluck('user_id')->toArray();
        $data = User::whereIn('id', $userIds)
            ->when($request->village_id, function ($q) use ($request) {
                $q->where('address_village_id', $request->village_id);
            })
            ->get();

        $govsInCourse = $this->getGovsInCourse($groups->pluck('city_id')->toArray());

        History::makeHistory(currentUser(),
            'Report',
            'export_groups_report',
        );
        return Excel::download(new PeriodCourseExport($data, $period, $course, $request->cols, $govsInCourse), 'تقرير_البرنامج_التفصيلي_' . str_replace("/", "-", $period->name) . '-' . str_replace("/", "-", $course->name) . time() . '.xlsx');
    }


    protected function getGovsInCourse($cityIds)
    {
        $cityIds = array_unique($cityIds);
        return City::whereIn('cities.id', $cityIds)
            ->join('governorates', 'governorates.id', '=', 'cities.governorate_id')
            ->select('governorates.id', 'governorates.governorate_name_ar')
            ->groupBy('governorates.id')->get();
    }


    public function exportStudentsInGroup(Request $request)
    {
        $this->validate($request, [
            'group_id' => 'required',
        ]);
        $group = Group::where('is_active', 1)->with('students')->find($request->group_id);
        if (!$group || !count($group->students))
            return back()->withErrors('لا يوجد متدربين حتي الآن لتحميل بياناتهم');

        History::makeHistory(auth()->user(),
            'Group',
            'download_students_details',
        );
        return Excel::download(new ReportGroupStudentDetailsExport($group, $group->students, $request->cols), 'بيانات_متدربين_مجموعة' . str_replace("/", "-", $group->name) . time() . '.xlsx');
    }


    public function getGroupsByCourseId(Request $request)
    {
        $groups = Group::where('course_id', $request->course_id)
            ->select('id', 'name')
            ->get();
        return response()->json($groups);
    }


    public function test_results_by_gov(Request $request)
    {
        $gov = Governorate::find($request->gov_id);
        $course = Course::find($request->course_id);

        $groupIds = Group::join('cities', 'cities.id', '=', 'groups.city_id')
            ->where('cities.governorate_id', $request->gov_id)
            ->where('groups.course_id', $request->course_id)
            ->pluck('groups.id')
            ->toArray();

        if (!empty($groupIds)) {

            $sql = "SELECT u.name, u.id_number, u.phone, t.title AS test_name, tr.value, t.type
                FROM group_user guser
                JOIN users u ON guser.user_id = u.id
                LEFT JOIN test_results tr ON u.id = tr.user_id
                LEFT JOIN tests t ON tr.test_id = t.id
                JOIN `groups` grp ON guser.group_id = grp.id
                JOIN cities city ON grp.city_id = city.id
                WHERE guser.group_id IN (" . implode(',', $groupIds) . ")
                ;";

            $data = DB::select($sql);

            $results = $this->loopThroughTestResults($data);
            $beforeType = $results['beforeType'];
            $afterType = $results['afterType'];
            $nullData = $results['nullData'];
        } else {
            $beforeType = [];
            $afterType = [];
            $nullData = [];
        }

        $group = new \stdClass();
        $group->name = $gov && $course ? $gov->governorate_name_ar . ' - ' . $course->name : '';

        return Excel::download(new TestResultsData($beforeType, $afterType, $nullData, $group), 'نتائج_مزود الخدمةين_في_الاختبارات_' . time() . '.xlsx');
    }
}
