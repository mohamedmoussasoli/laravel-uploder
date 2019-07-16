<?php


namespace Reactor\Uploader;

use Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class Uploader
{

    public static function uploadImage ($file, $path) {

        if (is_array($file)) {

            $names = [];

            foreach ($file as $singleFile) {

                $names[] = self::uploadImage($singleFile, $path);

            }

            return $names;

        }

        if ($file) {

            $image_name = now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $image = Image::make($file);

            $image->resize(500, null, function ($constraints) {
                $constraints->aspectRatio();
            });

            if (!file_exists($path)) {

                File::makeDirectory($path);

            }

            $image->save(rtrim($path, '/') . '/' . $image_name);

            return $image_name;

        }

        return null;

    }

    public static function uploadFile (UploadedFile $file, $path) {

        if (is_array($file)) {

            $names = [];

            foreach ($file as $singleFile) {

                $names[] = self::uploadFile($singleFile, $path);

            }

            return $names;

        }

        if ($file) {

            $file_name = now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!file_exists($path)) {

                File::makeDirectory($path);

            }

            $file->move($path, $file_name);

            return $file_name;

        }

        return null;

    }

}
