<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Models\History;
use App\Models\Setting;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    use CommonTrait;

    public function index(Request $request)
    {
        $data = Setting::orderBy('id', 'desc');
        $governorates = DB::table('governorates')->get();
        $model = 'Settings';
        return view('admin.settings.index', get_defined_vars());
    }


    public function update(Request $request)
    {
        if ($request->setting_type == Setting::social) {
            if ($this->updateSocial($request))
                return back()->with('success', __('messages.updated'));
        }

        if ($request->setting_type == 'menu') {
            if ($this->updateMenu($request))
                return back()->with('success', __('messages.updated'));
        }

        if ($request->setting_type == Setting::general) {
            if ($this->updateGeneral($request))
                return back()->with('success', __('messages.updated'));
        }

        if ($request->setting_type == Setting::media) {
            if ($this->updateMedia($request))
                return back()->with('success', __('messages.updated'));
        }

        if ($request->setting_type == Setting::flags_text) {
            if ($this->updateFlagsText($request))
                return back()->with('success', __('messages.updated'));
        }

        History::makeHistory(auth()->user(),
            'Setting',
            'update_settings',
            $request->id
        );
        return back()->with(__('com.some_thing_went_wrong'));
    }

    protected function updateSocial(Request $request)
    {
        $data = $request->except('_token', 'setting_type');

        History::makeHistory(auth()->user(),
            'Setting',
            'update_settings_social',
            $request->id,
        );
        return Setting::where('key', Setting::social)->update([
            'value' => json_encode($data),
        ]);
    }

    protected function updateGeneral(Request $request)
    {
        $data = $request->except('_token', 'setting_type');

        History::makeHistory(auth()->user(),
            'Setting',
            'update_settings_general',
            $request->id,
        );


        Setting::query()->updateOrCreate([
            'key' => 'm_mode',
        ], [
            'key' => 'm_mode',
            'value' => $request->m_mode ?? 'off'
        ]);

        return Setting::where('key', Setting::general)->update([
            'value' => json_encode($data),
        ]);
    }

    public function updateMenu($request)
    {
        $data = $request->except('_token', 'setting_type');

        return Setting::where('key', 'menu')->update([
            'value' => json_encode($data),
        ]);
    }

    public function updateMedia($request)
    {
        $logo = getSerializedSettingsData('media')?->logo;
        $ets_logo = getSerializedSettingsData('ets_logo')?->ets_logo;
        $fav_icon = getSerializedSettingsData('media')?->fav_icon;
        
        $data['logo'] = $request->logo ?: $logo;
        $data['ets_logo'] = $request->logo ?: $ets_logo;
        $data['fav_icon'] = $request->fav_icon ?: $fav_icon;

        History::makeHistory(auth()->user(),
            'Setting',
            'update_settings_media',
            $request->id,
        );

        return Setting::query()
            ->where('key', Setting::media)->update([
                'value' => json_encode($data),
            ]);

    }

    protected function updateFlagsText(Request $request)
    {
        $data = $request->except('_token', 'setting_type');

        History::makeHistory(auth()->user(),
            'Setting',
            'update_settings_flags_text',
            $request->id,
        );

        return Setting::where('key', Setting::flags_text)->update([
            'value' => json_encode($data),
        ]);
    }
}
