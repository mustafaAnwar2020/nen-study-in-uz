<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

trait CommonTrait
{

    public function upload_image($file, $folder, $resize = true, $slug = 'file_'): string
    {
        if (is_string($file) || is_null($file)) return $file;
        $resize = false;
        if (app()->environment(['staging', 'production'])) {
            $smb = env('UPLOADS_FOLDER');
        } else {
            $smb = public_path();
        }

        $filename = $slug . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $smb . '/uploads/' . $folder . '/';
        $file->move($path, $filename);

        // If resizing is requested
        if ($resize) {
            $image = Image::make($path . $filename);

            $image->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->save($path . $filename, 75); // 75 is the image quality
        }

        return '/uploads/' . $folder . '/' . $filename;
    }


    public function uploadFilesWithCompress(UploadedFile $file, string $after_path, string $prefix, int $width = 300, int $height = 300): string
    {
        $filename = $prefix . "_" . rand(1, time()) . "." . $file->getClientOriginalExtension();

        if (app()->environment(['staging', 'production'])) {
            $smb = env('UPLOADS_FOLDER');
        } else {
            $smb = public_path();
        }

        $path = $smb . '/uploads/' . $after_path . "/" . $filename;

        $img = Image::make($file);
        $img->resize($width, $height);
        $img->save($path);
        return '/uploads/' . $after_path . '/' . $filename;
    }


    public function deleteOldFile($file_name): bool
    {
        if ($file_name) {
            $path = public_path() . $file_name;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        return true;
    }


    protected function compressImage($source, $destination, $quality): bool
    {
        $source = public_path($source);
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, public_path($destination), $quality);
        return true;
    }


    public function sendGeneralNotification($user, $data, $emailTemp = 'emails.general', $sendViaEmail = true, $saveToDb = true): bool
    {
        try {
            if ($sendViaEmail && !isLocalEnv()) {
                Mail::send($emailTemp, ['data' => $data, 'user' => $user], function ($m) use ($user) {
                    $m->from(config('services.mail'), 'Yalla-Car');
                    $m->to($user->email, $user->name)->subject('Yalla-Car - إشعار جديد');
                });
            }

            if ($saveToDb) {
                DB::table('notifications')->insert([
                    'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'type' => 'App\Notifications\GeneralNotification',
                    'notifiable_type' => get_class($user),
                    'notifiable_id' => $user->id,
                    'data' => json_encode($data),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

        } catch (\Exception $e) {
            Log::error('SendingEmail OR SaveNotification:' . $e->getMessage());
        }

        return true;
    }

    public function getAdmin()
    {
        return User::query()->where('is_admin', 1)->first();
    }


}
