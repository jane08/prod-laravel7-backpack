<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    const READ = 1;
    const UNREAD = 0;

    // TYPES
    const TYPE_REGISTER = 'register';
    const TYPE_SCORE = 'score';
    const TYPE_EMPTY_PROJECT_LINK = 'empty_project_link';
    const TYPE_SECURITY_EMAIL = 'security_email';
    const TYPE_SECURITY_PASSWORD = 'security_password';
    const TYPE_NEW_EVENT = 'new_event';
    const TYPE_ERROR_TEST = 'error_test';
    const TYPE_APPROVED_TEST = 'approved_test';
    const TYPE_FINISHED_COURSE = 'approved_test';
    const TYPE_REFERRER_TEST_MODERATION = 'referrer_test_moderation';

    const SCORE_WORD = '#score#';
    const USERNAME_WORD = '#username#';

    const SCORE_TITLE = "Вам начислены баллы!";
    const SCORE_DESC = "Было начислено ".self::SCORE_WORD." баллов за приглашенного партнера.";
    const PARTNER_TITLE = "Новый партнер";
    const PARTNER_DESC = "Пользовтель ".self::USERNAME_WORD." зарегистрировался по вашему приглашению.";

    const SECURITY_EMAIL_TITLE = "Уведомление";
    const SECURITY_EMAIL_DESC = "Ваш email был успешно изменён";

    const SECURITY_PASSWORD_TITLE = "Уведомление";
    const SECURITY_PASSWORD_DESC = "Ваш пароль был успешно изменён";

    const NEW_EVENT_TITLE = "Мероприятия";
    const NEW_EVENT_DESC = "Появились новые события";


    const ERROR_TEST_MESS = "Вы не прошли тест курса {course}, урока {lesson}. Попробуйте пройти повторно.";
    const APPROVED_TEST_MESS = "Вы успешно прошли тест курса {course}, урока {lesson}.";
    const FINISHED_COURSE_MESS = "Вы успешно завершили курс {course}. Вам начислено {course_point} баллов.";
    const REFERRER_TEST_MESS = "{fio_refferal} отправил тест на модерацию по курсу {course}, уроку {lesson}. Ожидает вашей проверки.";

  /*
  |--------------------------------------------------------------------------
  | scopes
  |--------------------------------------------------------------------------
  */
    public function scopeUnread($query)
    {
        return $query->where('read', self::UNREAD)->orderBy('created_at', 'DESC');
    }
    public function scopeRead($query)
    {
        return $query->where('read', self::READ)->orderBy('created_at', 'DESC');
    }
}
