<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ImageHelper
{
    public static function setImageAttribute($value,$attribute_name,$destination_path,$obj)
    {
        //$attribute_name = "image";
        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name');
        // destination path relative to the disk above
        //$destination_path = "public/uploads/folder_1/folder_2";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($obj->{$attribute_name});

            // set null in the database column
            if(!empty($obj->attributes[$attribute_name])) {
                $obj->attributes[$attribute_name] = null;
            }
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image'))
        {

            $extenstion = "jpg";
            if (Str::startsWith($value, 'data:image/png'))
            {
                $extenstion = "png";
            }

            // 0. Make the image
            $image = \Image::make($value)->encode($extenstion, 90);

            // 1. Generate a filename.
            $filename = md5($value.time()).'.'.$extenstion;

            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            \Storage::disk($disk)->delete($obj->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            return $public_destination_path.'/'.$filename;
        }
        else
        {
            return  $value;
        }
    }
}
