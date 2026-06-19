<?php

namespace App\Traits;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait RegisterTrait
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'course_id' => ['required', 'exists:courses,id'],
            'birth_date' => 'required',
            'birth_governorate_id' => 'required',
            'phone' => 'required:unique:users,phone',
            'social_status' => 'required',
            'gender' => 'required',
            'religion' => 'required',

            'qualification' => 'required',
            'q_governorate_id' => 'required',
            //'specialty' => 'required',
            //'qualification_date' => 'required',
            //
            //'edu_administration_id' => 'required',


            'id_number' => 'required|size:14|unique:users,id_number', // unique:users
            'id_issue_date' => 'required',
            'id_end_date' => 'required',
            'id_governorate' => 'required',
            'id_city' => 'required',


            'address_governorate_id' => 'required',
            'address_city_id' => 'required',

        ];
    }

    public function quickAddRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'course_id' => ['required', 'exists:courses,id'],
            'phone' => 'required:unique:users,phone',

            'id_number' => 'required|min:14|unique:users,id_number',

            'address_governorate_id' => 'required',
            'address_city_id' => 'required',
        ];
    }


    public function update_rules($user_id): array
    {
        return [
            // id number unique and ignore this user id
            'id_number' => ['required', 'size:14', Rule::unique('users')->ignore($user_id)],
            //'phone' => ['required', Rule::unique('users')->ignore($user_id),],

            'name' => ['required', 'string', 'max:255'],
            'course_id' => ['required', 'exists:courses,id'],
//            'birth_date' => 'required',
//            'birth_governorate_id' => 'required',
//
//            'social_status' => 'required',
//            'gender' => 'required',
//            'religion' => 'required',
//
//            'qualification' => 'required',
//            'q_governorate_id' => 'required',
//
//            'id_issue_date' => 'required',
//            'id_end_date' => 'required',
//            'id_governorate' => 'required',
//            'id_city' => 'required',
//
//
//            'address_governorate_id' => 'required',
//            'address_city_id' => 'required',
        ];
    }

    public function createUser(Request $request, $user_unique_code, $avatar)
    {
        $user = User::create([
            'name' => $request->name,
            'code' => $user_unique_code,
            'username' => $user_unique_code,
            'user_email' => $request->user_email ?? null,
            'password' => Hash::make($user_unique_code),
            'password_text' => $user_unique_code,
            //'avatar' => $avatar,
            'birth_date' => $request->birth_date,
            'birth_governorate_id' => $request->birth_governorate_id,
            'gender' => $request->gender,
            'job' => $request->job ?? null,
            'religion' => $request->religion,
            'social_status' => $request->social_status,
            'mobile' => $request->mobile ?? null,
            'phone' => $request->phone,
            'facebook' => $request->facebook ?? null,

            'guardian_name' => $request->guardian_name ?? null,
            'guardian_relation' => $request->guardian_relation ?? null,
            'guardian_job' => $request->guardian_job ?? null,
            'guardian_phone' => $request->guardian_phone ?? null,

            'qualification' => $request->qualification,
            'specialty' => $request->specialty,
            'qualification_date' => $request->qualification_date,
            'result_number' => $request->result_number ?? null,
            'result_percentage' => $request->result_percentage ?? null,
            'school_name' => $request->school_name ?? null,
            'q_governorate_id' => $request->q_governorate_id,
            'edu_administration_id' => $request->edu_administration_id ?? null,

            'address_governorate_id' => $request->address_governorate_id,
            'address_city_id' => $request->address_city_id,
            'address_village_id' => $request->address_village_id ?? null,
            'address' => $request->address ?? null,

            'id_number' => $request->id_number,
            'id_issue_date' => $request->id_issue_date,
            'id_end_date' => $request->id_end_date,
            'id_governorate' => $request->id_governorate,
            'id_city' => $request->id_city,
            'id_factory_number' => $request->id_factory_number ?? null,
            'solidarity_number' => $request->solidarity_number ?? null,
            'id_issuer' => $request->id_issuer ?? null,

            //
            'acquaintance_method' => $request->acquaintance_method ?? null,
            'coordinator_name' => $request->coordinator_name ?? null,
            'coordinator_phone' => $request->coordinator_phone ?? null,


        ]);

        $user->assignRole('student');
        return $user;
    }


    public function updateUser(Request $request, $user, $application)
    {
        $user->update([
            'name' => $request->name,
            'user_email' => $request->user_email ?? null,
            'birth_date' => $request->birth_date,
            'birth_governorate_id' => $request->birth_governorate_id,
            'gender' => $request->gender ?? $user->gender,
            'job' => $request->job ?? $user->job,
            'religion' => $request->religion ?? $user->religion,
            'social_status' => $request->social_status ?? $user->social_status,
            'mobile' => $request->mobile ?? $user->mobile,
            'phone' => $request->phone ?? $user->phone,
            'facebook' => $request->facebook ?? $user->facebook,

            'guardian_name' => $request->guardian_name ?? $user->guardian_name,
            'guardian_relation' => $request->guardian_relation ?? $user->guardian_relation,
            'guardian_job' => $request->guardian_job ?? $user->guardian_job,
            'guardian_phone' => $request->guardian_phone ?? $user->guardian_phone,

            'qualification' => $request->qualification ?? $user->qualification,
            'specialty' => $request->specialty ?? $user->specialty,
            'qualification_date' => $request->qualification_date ?? $user->qualification_date,
            'result_number' => $request->result_number ?? $user->result_number,
            'result_percentage' => $request->result_percentage ?? $user->result_percentage,
            'school_name' => $request->school_name ?? $user->school_name,
            'edu_administration_id' => $request->edu_administration_id ?? $user->edu_administration_id,
            'q_governorate_id' => $request->q_governorate_id ?? $user->q_governorate_id,

            'address_governorate_id' => $request->address_governorate_id ?? $user->address_governorate_id,
            'address_city_id' => $request->address_city_id ?? $user->address_city_id,
            'address_village_id' => $request->address_village_id ?? $user->address_village_id,
            'address' => $request->address ?? $user->address,

            'id_number' => $request->id_number ?? $user->id_number,
            'id_issue_date' => $request->id_issue_date ?? $user->id_issue_date,
            'id_end_date' => $request->id_end_date ?? $user->id_end_date,
            'id_governorate' => $request->id_governorate ?? $user->id_governorate,
            'id_city' => $request->id_city ?? $user->id_city,
            'id_factory_number' => $request->id_factory_number ?? $user->id_factory_number,
            'solidarity_number' => $request->solidarity_number ?? $user->solidarity_number,
            'id_issuer' => $request->id_issuer ?? $user->id_issuer,
            //
            'acquaintance_method' => $request->acquaintance_method ?? null,
            'coordinator_name' => $request->coordinator_name ?? null,
            'coordinator_phone' => $request->coordinator_phone ?? null,
        ]);

        $application->update(['course_id' => $request->course_id]);
    }


    // unique code foreach user
    protected function generateUserCode()
    {
        $number = mt_rand(10000, 99999);
        if ($this->CodeNumberExists($number)) {
            return $this->generateUserCode();
        }
        return $number;
    }

    public function CodeNumberExists($number)
    {
        return User::where('code', $number)->exists();
    }


}
