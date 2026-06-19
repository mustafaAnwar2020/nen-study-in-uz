<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\History;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    use CommonTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Country::ordered();
        
        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where(function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }
        
        $data = $data->paginate(20);
        $model = 'Countries';
        
        return view('admin.countries.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = 'Countries';
        return view('admin.countries.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:2|unique:countries,code',
            'name' => 'required|string|max:255',
            'flag_icon' => 'nullable|string|max:255',
            'registration_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $country = Country::create([
            'code' => strtolower($request->code),
            'name' => $request->name,
            'flag_icon' => $request->flag_icon,
            'registration_url' => $request->registration_url,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        History::makeHistory(
            auth()->user(),
            'Country',
            'create_country',
            $country->id
        );

        return redirect()->route('admin.countries.index')
                        ->with('success', __('messages.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::findOrFail($id);
        $model = 'Countries';
        return view('admin.countries.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);
        $model = 'Countries';
        return view('admin.countries.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:2|unique:countries,code,' . $id,
            'name' => 'required|string|max:255',
            'flag_icon' => 'nullable|string|max:255',
            'registration_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $country->update([
            'code' => strtolower($request->code),
            'name' => $request->name,
            'flag_icon' => $request->flag_icon,
            'registration_url' => $request->registration_url,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        History::makeHistory(
            auth()->user(),
            'Country',
            'update_country',
            $country->id
        );

        return redirect()->route('admin.countries.index')
                        ->with('success', __('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        
        History::makeHistory(
            auth()->user(),
            'Country',
            'delete_country',
            $country->id
        );
        
        $country->delete();

        return redirect()->route('admin.countries.index')
                        ->with('success', __('messages.deleted'));
    }
}
