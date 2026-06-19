<?php

namespace App\Http\Controllers\Admin;

use App\Models\History;
use App\Models\Offer;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    use CommonTrait;

    public function index(Request $request)
    {
        $rows = Offer::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->date && $request->date != '') {
            $rows->where('date', $request->date);
        }

        if ($request->country_code && $request->country_code != '') {
            $rows->where('country_code', $request->country_code);
        }

        $rows = $rows->paginate(20);
        $model = 'Offers';
        return view('admin.offers.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Offer';
        return view('admin.offers.manage', get_defined_vars());
    }


    public function edit($slug)
    {
        $row = Offer::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit offer - ' . $row->name;
        return view('admin.offers.manage', get_defined_vars());
    }


    public function store(Request $request)
    {
        $request->merge([
            'book_now_text' => $request->input('book_now_text') ?: null,
            'more_details_text' => $request->input('more_details_text') ?: null,
            'more_details_url' => $request->input('more_details_url') ?: null,
        ]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'nullable|max:255',
            'book_now_url' => 'nullable|string|max:2048',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'video' => 'nullable|string|max:2048',
            'pdf' => 'nullable|string|max:2048',
            'country_code' => 'required|string',
            'use_book_now' => 'nullable|boolean',
            'book_now_country_links' => 'nullable|array',
            'book_now_country_links.*.country' => 'nullable|string|max:10',
            'book_now_country_links.*.url' => 'nullable|url|max:2048',
            'book_now_text' => 'nullable|string|max:255',
            'more_details_text' => 'nullable|string|max:255',
            'more_details_url' => 'nullable|url|max:2048',
        ]);

        $isUpdate = (bool) $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $oldRow = null;
        $image = null;
        $video = null;
        $pdf = null;

        if ($isUpdate) {
            $oldRow = Offer::findOrFail($request->row_id);
            $image = $oldRow->image;
            $video = $oldRow->video;
            $pdf = $oldRow->pdf;

            if ($request->filled('image')) {
                $this->deleteOldFile($oldRow->image);
            }

            $data['slug'] = $oldRow->slug;
        } else {
            $data['slug'] = Offer::generateSlug();
        }

        if ($request->filled('image')) {
            $image = $request->image;
        }

        if ($request->boolean('remove_video')) {
            if ($oldRow && $oldRow->video) {
                $this->deleteOldFile($oldRow->video);
            }
            $video = null;
        } elseif ($request->filled('video')) {
            if ($oldRow && $oldRow->video && $oldRow->video !== $request->video) {
                $this->deleteOldFile($oldRow->video);
            }
            $video = $request->video;
        }

        if ($request->boolean('remove_pdf')) {
            if ($oldRow && $oldRow->pdf) {
                $this->deleteOldFile($oldRow->pdf);
            }
            $pdf = null;
        } elseif ($request->filled('pdf')) {
            if ($oldRow && $oldRow->pdf && $oldRow->pdf !== $request->pdf) {
                $this->deleteOldFile($oldRow->pdf);
            }
            $pdf = $request->pdf;
        }

        $data['image'] = $image;
        $data['video'] = $video;
        $data['pdf'] = $pdf;
        $data['is_active'] = (bool)$request->is_active;
        $data['is_online'] = (bool)$request->is_online;
        $data['is_special'] = (bool)$request->is_special;

        $data['use_book_now'] = $request->boolean('use_book_now');
        if ($data['use_book_now'] && $request->has('book_now_country_links') && is_array($request->book_now_country_links)) {
            $filtered = array_values(array_filter(
                $request->book_now_country_links,
                fn ($e) => !empty($e['url'] ?? '') && !empty($e['country'] ?? '')
            ));
            $data['book_now_by_country'] = !empty($filtered) ? json_encode($filtered) : null;
            $data['book_now_url'] = null;
        } else {
            $data['book_now_by_country'] = null;
        }

        unset($data['book_now_country_links']);

        $brand = Offer::query()->updateOrCreate(['id' => $request->row_id], $data);

        History::makeHistory(auth()->user(),
            'Offer',
            'create',
            $brand->id
        );

        return redirect()->route('admin.offers.index')->with('success', $status);
    }


}
