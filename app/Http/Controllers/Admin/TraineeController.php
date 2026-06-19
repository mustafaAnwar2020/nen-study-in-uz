<?php
namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\History;
use App\Models\Provider;
use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TraineeRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Provider\TraineesImport;

class TraineeController extends Controller
{
    public function index(Request $request)
    {
        // $rows = Provider::query()->latest()->whereHas('traineeRequests', function ($query) {
        //     $query->where('name', TraineeRequest::requests['profile_process'])
        //         ->where('status', '!=', 6);
        // });
        $rows = Provider::query()->latest();

        if ($request->email && $request->email != '') {
            $rows->whereHas('owner', function ($query) use ($request) {
                $query->where('email', 'like', '%' . $request->email . '%');
            });
        }

        if ($request->name && $request->name != '') {
            // search in center_name in owners table or seach in centers name
            /* $rows->whereHas('owner', function ($query) use ($request) {
                $query->where('center_name', 'like', '%' . $request->name . '%');
            });*/

            $rows->orWhere('name', 'like', '%' . $request->name . '%');
        }

        if ($request->governorate_id && $request->governorate_id != '') {
            $rows->where('governorate_id', $request->governorate_id);
        }

        $rows = $rows->paginate(20);

        $counters = $this->getCounters();

        $model = 'مزود الخدمةين';
        return view('admin.trainees.index', get_defined_vars());
    }


    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|max:10000|mimes:xlsx,xls',
            ]);
            Excel::import(new TraineesImport($request->course_id), $request->file('file')->store('temp'));
            return back()->with('success', 'تم تحميل الملف بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحميل الملف');
        }
    }



    public function show(Center $center, Request $request)
    {
        $model = 'المراكز التدريبية - ' . $center->name;

        if ($request->process) {
            $data = $center->customFields()->where('parent', $request->process)
                ->get()->groupBy('group');
        } else {
            $customFieldParents = $center->centerRequests()->get();
        }


        return view('admin.centers.show', get_defined_vars());
    }

    public function profileStatus(Request $request)
    {
        $center = Center::find($request->center_id);
        $users = User::all();
        $html = view('admin.centers.profile_status', get_defined_vars())->render();
        return response()->json(['html' => $html]);
    }

    public function updateStatus(Request $request, Center $center)
    {
        $visitDetails = [];

        // visiting center
        if ($request->status == '3') {

            $this->validate($request, [
                'visit_date' => 'required|date',
                'user_id' => 'required|exists:users,id'
            ]);

            $visitDetails['visit_date'] = $request->visit_date;
            $visitDetails['user_id'] = $request->user_id;

            $data['title'] = 'هناك زيارة قادمة لك للمركز' . $center->name;
            $data['body'] = 'تم تحديد موعد للزيارة لمركز ' . $center->name . ' في ' . $request->visit_date;

            sendNotification(User::find($request->user_id), $data, 'general_notification', true, 'User');
        }

        $center->centerRequests()->where('name', CenterRequest::requests['profile_process'])
            ->update(['status' => $request->status,
                'visit_details' => json_encode($visitDetails),
            ]);

        // send notification
        $data['title'] = 'تمت تحديث حالة طلبك';
        $data['body'] = 'هناك تحديث جديد في حالة طلبك إلي' . ' " ' . $center->getProfileStatus() . ' " ';
        sendNotification($center->owner, $data, 'general_notification', true, 'Owner');


        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function approveGroup(Request $request)
    {
        $customField = CustomField::find($request->customField);

        CustomField::where([
            'center_id' => $customField->center_id,
            'group' => $customField->group,
            'parent' => $customField->parent
        ])->update(['status' => 'done']);

        // send notification
        $data['title'] = 'تمت الموافقة على مجموعة من البيانات في طلبك';
        $data['body'] = 'تمت الموافقة على بيانات' . __('keys.' . $customField->group) . ' بنجاح';
        sendNotification($customField->center->owner, $data, 'general_notification', true, 'Owner');

        return redirect()->back()->with('success', 'تمت الموافقة على المجموعة بنجاح');
    }


    public function rejectGroup(Request $request)
    {
        $customField = CustomField::find($request->custom_field_id);

        CustomField::where([
            'center_id' => $customField->center_id,
            'group' => $customField->group,
            'parent' => $customField->parent
        ])->update(['status' => 'rejected', 'comment' => $request->reason]);


        // send notification
        $data['title'] = 'تم رفض مجموعة من البيانات في طلبك';
        $data['body'] = 'تم رفض مجموعة من الحقول بسبب ' . $request->reason;
        sendNotification($customField->center, $data, 'general_notification', true, 'Center');

        return redirect()->back()->with('success', 'تم رفض المجموعة بنجاح');
    }

    public function status(Center $center)
    {
        $center->is_active = !$center->is_active;
        $center->save();

        return redirect()->back()->with('success', 'تم تحديث حالة المركز بنجاح');
    }

    public function delete(Center $center)
    {
        try {
            History::makeHistory(auth()->user(),
                'Center',
                'center_delete',
                $center->id
            );
            $center->students()->delete();
            $center->centerRequests()->delete();
            $center->customFields()->delete();
            $center->delete();

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'لا يمكن حذف المركز لوجود بيانات مرتبطة به');
        }

        return redirect()->back()->with('success', 'تم حذف المركز بنجاح');
    }


    public function getCounters()
    {

        $sql = "SELECT
        (SELECT COUNT(*) FROM trainee_requests) AS all_requests,
        (SELECT COUNT(*) FROM trainee_requests where status = 0) AS new_requests,
        (SELECT COUNT(*) FROM trainee_requests where status != 0) AS  approved_requests";

        return DB::select($sql)[0];
    }

}
