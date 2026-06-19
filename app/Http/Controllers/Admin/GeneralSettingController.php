<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{

    public function changePassword(Request $request)
    {
        $data  = $request->all();
        $model = 'تغيير كلمة المرور';
        return view('admin.general_settings.update-passwords', get_defined_vars());
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'row_id'   => 'required',
            'model'    => 'required',
            'password' => 'required',
        ]);

        $modelClassName = "App\Models\\" . $request->model;

        $row = $modelClassName::find($request->row_id);

        if (!$row) {
            return abort(404, 'لم يتم العثور علي العنصر.');
        }

        $row->password = bcrypt($request->password);
        $row->save();

        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'model'    => 'required',
            'model_id' => 'required',
            'status'   => 'required',
        ]);

        try {
            $modelClassName = "App\Models\\" . $request->model;
            $modelClassName::where('id', $request->model_id)->update(['is_active' => $request->status == 'active' ? 1 : 0]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the status. Please try again later.');
        }


        return redirect()->back()->with('success', 'The status has been successfully updated.');

    }

    public function delete(Request $request)
    {
        $request->validate([
            'model'    => 'required',
            'model_id' => 'required',
        ]);

        try {
            $modelClassName = "App\Models\\" . $request->model;
            $modelClassName::where('id', $request->model_id)->delete();

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the item. Please try again later.');
        }


        return redirect()->back()->with('success', 'The item has been successfully deleted.');

    }


}
