<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Course;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Traits\CommonTrait;
use App\Traits\RegisterTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers, CommonTrait, RegisterTrait;


    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }
    /*
        public function showRegistrationForm()
        {
            $courses = Course::all();
            return view('site.register', get_defined_vars());
        }


        protected function validator(array $data)
        {
            return Validator::make($data, $this->rules());
        }

        protected function create(array $data)
        {
            $avatar = null;
            if (isset($data['avatar']))
                $avatar = $this->upload_image($data['avatar'], 'students', 'st_');

            $user = DB::transaction(function () use ($data, $avatar) {
                $user_unique_code = $this->generateUserCode();
                $user = User::create([
                    'name' => $data['name'],
                    'code' => $user_unique_code,
                    'username' => 'user_' . $user_unique_code,
                    'user_email' => $data['email'] ?? null,
                    'password' => Hash::make('#' . $user_unique_code),
                    'password_text' => '#' . $user_unique_code,
                    'role' => 'student',
                    'avatar' => $avatar,
                    'birth_date' => $data['birth_date'],
                    'birth_governorate_id' => $data['birth_governorate_id'],
                    'gender' => $data['gender'] ?? null,
                    'religion' => $data['religion'] ?? null,
                    'social_status' => $data['social_status'] ?? null,
                    'mobile' => $data['mobile'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'facebook' => $data['facebook'] ?? null,

                    'guardian_name' => $data['guardian_name'] ?? null,
                    'guardian_relation' => $data['guardian_relation'] ?? null,
                    'guardian_job' => $data['guardian_job'] ?? null,
                    'guardian_phone' => $data['guardian_phone'] ?? null,

                    'qualification' => $data['qualification'] ?? null,
                    'specialty' => $data['specialty'] ?? null,
                    'qualification_date' => $data['qualification_date'] ?? null,
                    'q_address' => $data['q_address'] ?? null,
                    'result_number' => $data['result_number'] ?? null,
                    'result_percentage' => $data['result_percentage'] ?? null,
                    'school_name' => $data['school_name'] ?? null,
                    'edu_administration' => $data['edu_administration'] ?? null,

                    'address_governorate_id' => $data['address_governorate_id'] ?? null,
                    'address_city_id' => $data['address_city_id'] ?? null,
                    'address_village_id' => $data['address_village_id'] ?? null,
                    'address' => $data['address'] ?? null,

                    'id_number' => $data['id_number'] ?? null,
                    'id_issue_date' => $data['id_issue_date'] ?? null,
                    'id_governorate' => $data['id_governorate'] ?? null,
                    'id_city' => $data['id_city'] ?? null,
                ]);

                Application::create([
                    'user_id' => $user->id,
                    'course_id' => $data['course_id'],
                ]);

                session()->flash('message', "تم تسجيل طلب الحجز بنجاح");
                return $user;
            });

            if ($user)
                return $user;

            return redirect(route('login'))->with('success', 'Your have applied to this course successfully. Login now');

        }
    */


}
