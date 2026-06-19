<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Event;
use App\Models\Governorate;
use App\Models\Offer;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AjaxController extends Controller
{
    use CommonTrait;

    public function getCities(Request $request)
    {
        $html = '';
        $data = City::where('governorate_id', $request->gov_id)->get();
        foreach ($data as $city) {
            $html .= '<option value="' . $city->id . '">' . $city->city_name_ar . '</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function getCitiesByGovID($id)
    {
        $html = '<option value="" disabled >اختر المدينة</option>';
        $gov  = Governorate::find($id);
        $data = $gov->cities;
        foreach ($data as $city) {
            $html .= '<option value="' . $city->id . '">' . $city->city_name_ar . '</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function getOfferDetails(Request $request)
    {
        $offer = Offer::find($request->offer_id);
        $html  = view('site.helpers.offer-modal', ['offer' => $offer])->render();
        return response()->json($html);
    }

    public function getEventDetails(Request $request)
    {
        $event = Event::query()->active()->find($request->event_id);

        if (!$event) {
            return response()->json(['message' => 'Event not found.'], 404);
        }

        $html = view('site.helpers.event-modal', ['event' => $event])->render();

        return response()->json($html);
    }


    public function fileUpload(Request $request)
    {
        if (auth()->user() || currentProvider() || currentCompany()) {

            $kind = $request->input('upload_kind', 'default');
            $fileRules = match ($kind) {
                'offer_video' => ['required', 'file', 'max:102400', 'mimes:mp4,m4v,mov,webm,ogg'],
                'offer_pdf', 'event_pdf' => ['required', 'file', 'max:20480', 'mimes:pdf'],
                default => ['required', 'file', 'max:3048', 'mimes:pdf,jpg,jpeg,png,xls,xlsx'],
            };

            $validator = Validator::make($request->all(), [
                'file'   => $fileRules,
                'folder' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }

            $path = $this->upload_image($request->file, $request->folder);

            return response()->json([
                'status' => true,
                'path'   => $path,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'errors' => 'Not allowed',
            ], 403);
        }

    }


    public function getNetworkDataFromXLSFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|string',
            'folder'  => 'required|string|in:test-sites,trainers',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }


        $countryCode = $request->country;
        $folder      = $request->folder;

        $data = $this->readExcelFile("xls/network/{$folder}/{$countryCode}/file.xlsx");

        $data = view('site.network.' . $folder, compact('data'))->render();

        return response()->json(['status' => 'success', 'data' => $data,]);
    }


    protected function readExcelFile(string $relativePath): ?Collection
    {
        $filePath = database_path($relativePath);

        if (!file_exists($filePath)) {
            return null;
        }

        $sheet = Excel::toCollection(null, $filePath)->first();

        if ($sheet->isEmpty()) {
            return null;
        }

        return $sheet->map(function ($row) {
            return $row->filter()->values();
        })->filter(function ($row) {
            return $row->isNotEmpty();
        });

    }


}
