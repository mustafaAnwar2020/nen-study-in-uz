<?php

use App\Models\City;
use App\Models\Governorate;
use App\Models\PageContent;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


if (!function_exists('currentUser')) {
    function currentUser()
    {
        return auth()->user();
    }
}

if (!function_exists('currentProvider')) {
    function currentProvider()
    {
        return auth('provider')->user();
    }
}


if (!function_exists('assetVersion')) {
    function assetVersion()
    {
        return '?v=5.0.0';
    }
}


if (!function_exists('currentCompany')) {
    function currentCompany()
    {
        return auth('company')->user();
    }
}
if (!function_exists('currentCompanyBranchesIds')) {
    function currentCompanyBranchesIds()
    {
        $company = auth('company')->user();

        if ($company->parent_id) {
            return collect([$company->id]);
        }

        return $company->children()->pluck('id');
    }
}


if (!function_exists('isLocalEnv')) {
    function isLocalEnv()
    {
        return env('APP_ENV') == 'local';
    }
}


if (!function_exists('getProductCategories')) {
    function getProductCategories()
    {
        return \App\Models\ProductCategory::query()->with('products')->get();
    }
}


if (!function_exists('getYoutubeEmbedUrl')) {
    function getYoutubeEmbedUrl($url): string
    {
        $parsedUrl = parse_url($url);
        parse_str(@$parsedUrl['query'], $queryString);
        return @$queryString['v'] ?? substr(@$parsedUrl['path'], 1);
    }
}


if (!function_exists('lang')) {
    function lang(): string
    {
        return app()->getLocale();
    }
}


if (!function_exists('countModel')) {
    function countModel($model)
    {
        $modelName = '\App\Models' . '\\' . $model;
        return $modelName::all()->count();
    }
}

if (!function_exists('countModelWhere')) {
    function countModelWhere($model, $key, $value)
    {
        $modelName = '\App\Models' . '\\' . $model;
        return $modelName::where($key, $value)->count();
    }
}

if (!function_exists('getGovernorates')) {
    function getGovernorates($isActive = false): Collection
    {
        return DB::table('governorates')->get();
    }
}


if (!function_exists('getAllGovernorates')) {
    function getAllGovernorates(): Collection
    {
        return Governorate::get();
    }
}

if (!function_exists('getGovById')) {
    function getGovById($id)
    {
        if ($id) {
            $data = DB::table('governorates')->get();
            return $data->where('id', $id)->first()->governorate_name_ar ?? null;
        }
        return null;
    }
}


if (!function_exists('getEduAdminById')) {
    function getEduAdminById($id)
    {
        return EduAdministration::find($id)->name ?? null;
    }
}

if (!function_exists('getCities')) {
    function getCities($govId = null): Collection
    {
        // cities join with governorates
        if (!$govId) {
            return City::join('governorates', 'governorates.id', '=', 'cities.governorate_id')
                ->where('governorates.is_active', true)
                ->select('cities.*', 'governorates.governorate_name_ar')
                ->orderBy('governorates.governorate_name_ar', 'asc')
                ->get();
        }

        return City::where('governorate_id', $govId)->get();

    }
}


if (!function_exists('getCitiesHasApplications')) {
    function getCitiesHasApplications()
    {
        $cities_ids = Application::join('users', 'users.id', '=', 'applications.user_id')
            ->join('cities', 'cities.id', '=', 'users.address_city_id')
            ->pluck('users.address_city_id')
            ->toArray();

        return City::whereIn('id', $cities_ids)->get();
    }
}

if (!function_exists('getAllCities')) {
    function getAllCities(): Collection
    {
        return City::join('governorates', 'governorates.id', '=', 'cities.governorate_id')
            ->select('cities.*', 'governorates.governorate_name_ar')
            ->orderBy('governorates.governorate_name_ar', 'asc')
            ->get();
    }
}

if (!function_exists('getSerializedSettingsData')) {
    function getSerializedSettingsData($key)
    {
        return json_decode(Setting::query()->where('key', $key)->first()->value ?? null);
    }
}

if (!function_exists('getSettingByKey')) {
    function getSettingByKey($key)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : null;
    }
}

if (!function_exists('getUnserializedData')) {
    function getUnserializedData($text)
    {
        if ($text)
            return unserialize($text);
        return [];
    }
}


if (!function_exists('removeNullValuesFromArray')) {
    function removeNullValuesFromArray($array): array
    {
        return array_filter($array, function ($v) {
            return !is_null($v);
        });
    }
}

if (!function_exists('removeNullValuesFromArrayOfArray')) {
    function removeNullValuesFromArrayOfArray($array): array
    {
        return array_filter($array, function ($v) {
            return !in_array(null, $v);
        });
    }
}

if (!function_exists('getSectionByKey')) {
    function getSectionByKey($key)
    {
        return PageContent::query()
            ->where('key', $key)->first();
    }
}


if (!function_exists('getInstructors')) {
    function getInstructors()
    {
        return User::role('instructor')->get();
    }
}

if (!function_exists('userWhereRole')) {
    function userWhereRole($role)
    {
        return User::where('role', $role)->get();
    }
}

if (!function_exists('userWhereInRoles')) {
    function userWhereInRoles($roles)
    {
        return User::whereIn('role', $roles)->get();
    }
}

if (!function_exists('getOurPartners')) {
    function getOurPartners()
    {
        return Partner::all();
    }
}

if (!function_exists('cutTitle')) {
    function cutTitle($string, $length = 20): string
    {
        if (strlen($string) > $length)
            return mb_substr($string, 0, $length) . ' ..';
        return $string;
    }
}

if (!function_exists('getCountryById')) {
    function getCountryById($id)
    {
        if (is_string($id) || is_null($id)) return null;
        if ($id) {
            $data = Governorate::get();
            return $data->where('id', $id)->first()->name_ar;
        }
        return null;
    }
}

if (!function_exists('getCityById')) {
    function getCityById($id)
    {
        if (is_string($id) || is_null($id)) return null;
        return DB::table('cities')->where('id', $id)->first()->city_name_ar ?? null;
    }
}

if (!function_exists('getVillageById')) {
    function getVillageById($id)
    {
        if (is_string($id) || is_null($id)) return null;
        if ($id) {
            $data = DB::table('villages')->get();
            return $data->where('id', $id)->first()->name ?? null;
        }
        return null;
    }
}

if (!function_exists('testRates')) {
    function testRates(): array
    {
        return [
            1 => 'لا أعلمه',
            2 => 'معلوماتي بسيطة',
            3 => 'معلوماتي متوسطة',
            4 => 'معلوماتي جيدة',
            5 => 'أعلمه واتقنه',
        ];
    }
}

if (!function_exists('fileDocsTypes')) {
    function fileDocsTypes(): array
    {
        return [
            'id'                => 'بطاقة الرقم القومي امامية',
            'id_back'           => 'بطاقة الرقم القومي خلفية',
            'avatar'            => 'صورة شخصية',
            'signed_doc'        => 'صورة الطلب بعد التوقيع',
            'obligation'        => 'صورة الإقرار امامية',
            'obligation_back'   => 'صورة الإقرار خلفية',
            'birth_certificate' => 'شهادة ميلاد',
            'passport'          => 'جواز السفر',
            'qualification'     => 'صورة المؤهل',
        ];
    }
}


if (!function_exists('getDateTimeToView')) {
    function getDateTimeToView($dateTime): string
    {
        $strToTime = strtotime($dateTime);
        return date('Y-m-d', $strToTime) . ' - ' . date('g:i A', $strToTime);
    }
}

if (!function_exists('arrayHasDupes')) {
    function arrayHasDupes($array)
    {
        return count($array) !== count(array_unique($array));
    }
}


if (!function_exists('getFileExtensionFromPath')) {
    function getFileExtensionFromPath($path)
    {
        $n = strrpos($path, '.');
        return ($n === false) ? '' : substr($path, $n + 1);
    }
}

if (!function_exists('is_serialized')) {
    function is_serialized($string)
    {
        try {
            unserialize($string);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}

function checkIfArrayHasNullValues($array): bool
{
    foreach ($array as $item) {
        if (is_null($item)) {
            return true;
        }
    }
    return false;
}

function checkDOBMatchesIdNumber($idNumber, $dob): bool
{
    if (app()->environment('local'))
        return true;
    $year  = substr($idNumber, 1, 2);
    $month = substr($idNumber, 3, 2);
    $day   = substr($idNumber, 5, 2);

    $yearFromBob  = substr($dob, 2, 2);
    $monthFromBob = substr($dob, 5, 2);
    $dayFromBob   = substr($dob, 8, 2);

    if ($year != $yearFromBob || $month != $monthFromBob || $day != $dayFromBob) {
        return false;
    }

    return true;
}


function getDataFromCollectionByKey($key, $collection, $required = 'value')
{
    if (empty($collection)) {
        return null;
    }
    $result = $collection->where('key', $key)->first();
    return $result ? $result->{$required} : null;
}


function getJsonDataAsArray($key, $collection)
{
    if (empty($collection)) {
        return [];
    }

    $result = getDataFromCollectionByKey($key, $collection);
    if ($result)
        return json_decode($result);

    return [];
}


function criticalLog($userName, $message = null)
{
    try {
        Log::channel('single')->critical($message ?? 'Critical issue in the system', [
            'Environment'  => app()->environment(),
            'Request url'  => request()->method() . ' ' . request()->url(),
            'User'         => $userName . ' (' . request()->ip() . ')',
            'Request Body' => [json_encode(request()->all())]
        ]);
    } catch (\Exception $e) {

    }
}


function getCoursesNames($jsonId): string
{
    $html = '';

    $data = getCoursesNamesAsArray($jsonId);
    foreach ($data as $key => $value) {
        $html .= $value . '<br>';
    }

    return rtrim($html, ', ');
}


function getUserById($id)
{
    return User::find($id);
}


if (!function_exists('limitText')) {
    function limitText($text, $num = 40): ?string
    {
        if (!$text || !is_string($text) || empty($text) || mb_strlen($text) <= $num)
            return $text;
        return Str::limit($text, $num, '...');
    }
}

function formatDate($dateString): string
{
    if (is_null($dateString))
        return '';
    return Carbon::parse($dateString)->format('F j, Y, g:i a');
}


if (!function_exists('getCoordinatesFromGoogleMapsUrl')) {
    function getCoordinatesFromGoogleMapsUrl($url): ?array
    {
        preg_match('/@([0-9.-]+),([0-9.-]+)/', $url, $matches);
        if (!empty($matches[1]) && !empty($matches[2])) {
            return ['latitude' => $matches[1], 'longitude' => $matches[2]];
        }
        return null;
    }
}

if (! function_exists('landing_get')) {
    function landing_get(object $landing, string $key): mixed
    {
        return \App\Support\LandingContent::get($landing, $key);
    }
}

if (! function_exists('is_rtl')) {
    function is_rtl(): bool
    {
        return app()->getLocale() === 'ar';
    }
}