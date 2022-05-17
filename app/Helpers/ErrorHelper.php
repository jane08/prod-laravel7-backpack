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
                    'error_text' => \App\Models\StaticTrans::t("errors_page_not_found","Page not found",\App\Models\MenuItem::PAGE_ERRORS),
                ]
            ];
            return response()->json($arr);

    }

    public static function getSigninError()
    {

        $arr = [
            'data' => [
                'error' => '401',
                'error_text' =>\App\Models\StaticTrans::t("errors_enter_email_password","Enter your email and password",\App\Models\MenuItem::PAGE_ERRORS),
            ]
        ];
        return response()->json($arr);

    }

    public static function getUserError()
    {

        $arr = [
            'data' => [
                'error' => '405',
                'error_text' => \App\Models\StaticTrans::t("errors_login_please","Login please",\App\Models\MenuItem::PAGE_ERRORS),
            ]
        ];
        return response()->json($arr);

    }

}
