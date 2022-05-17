<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class FileHelper
{
    public static function setFileAttribute($value,$attribute_name,$destination_path,$obj)
    {
        //$attribute_name = "image";
        // or use your own disk, defined in config/filesystems.php
        $disk = 'public';
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


            return  $value;

    }
}
