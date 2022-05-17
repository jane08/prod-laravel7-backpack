<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Promo;
use App\Models\StaticTrans;
use App\Models\StrikeEvent;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationService
{
    public static function getAll()
    {
        return Notification::all();
    }

    public static function getOne($id)
    {
        return Notification::where(['id'=>$id])->get()->first();
    }

    public static function getAllUnread($user_id)
    {
        return Notification::unread()->where(['user_id'=>$user_id])->get();
    }

    public static function getAllRead($user_id)
    {
        return Notification::read()->where(['user_id'=>$user_id])->get();
    }

    public static function getAllUnreadByIds($ids)
    {
        return Notification::unread()->whereIn('id', $ids)->get();
    }
    public static function getAllByIds($ids)
    {
        return Notification::whereIn('id', $ids)->get();
    }

    public static function saveNotification($user_id,$type,$title,$desc,$strike_event_id=null)
    {
        $notification = new Notification();
        $notification->user_id = $user_id;
        $notification->title = $title;
        $notification->description = $desc;
        $notification->type = $type;
        $notification->strike_event_id = $strike_event_id;
        $notification->read = Notification::UNREAD;
        $notification->date = Carbon::now()->toDateTimeString();
        $notification->save();
        return $notification;
    }

}
