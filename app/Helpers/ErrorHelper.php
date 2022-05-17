<?php

namespace App\Helpers;

class ErrorHelper
{
  public static function getErrors($request)
  {
      if (!empty($request->get('error'))) {
          $arr = [
              'data' => [
                  'error' => $request->get('error'),
                  'error_text' => $request->get('error_text'),
              ]
          ];
          return response()->json($arr);
      }
  }

    public static function get404Error()
    {

            $arr = [
                'data' => [
                    'error' => '404',
                    'error_text' => 'Страница не найдена',
                ]
            ];
            return response()->json($arr);

    }

    public static function getSigninError()
    {

        $arr = [
            'data' => [
                'error' => '401',
                'error_text' => 'Введите email и пароль',
            ]
        ];
        return response()->json($arr);

    }

    public static function getUserError()
    {

        $arr = [
            'data' => [
                'error' => '405',
                'error_text' => 'Авторизируйтесь, пожалуйста',
            ]
        ];
        return response()->json($arr);

    }

}
