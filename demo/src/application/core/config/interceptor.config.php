<?php
/*****************************************************/
/* I N T E R C E P T O R C O U N F I G U R A T I O N */
/*****************************************************/

return array(
    //Web用
    'action' => array(
        //メンテナンス中確認
        'Core\Controller\Interceptor\Marker\InMaintenanceAware' => 
            'Core\Controller\Interceptor\InMaintenanceInterceptor',

        //セッション発行
        'Core\Controller\Interceptor\Marker\SessionAware' => 
            'Core\Controller\Interceptor\SessionInterceptor',

        //SSL配下のみ許可
        'Core\Controller\Interceptor\Marker\HttpsOnlyAware' => 
            'Core\Controller\Interceptor\HttpsOnlyInterceptor',

        //認証処理
        'Core\Controller\Interceptor\Marker\AuthenticateLoginAware' => 
            'Core\Controller\Interceptor\AuthenticationInterceptor',

        //認可処理
        'Core\Controller\Interceptor\Marker\AuthenticatedAware' => 
            'Core\Controller\Interceptor\AuthenticationInterceptor',

        //CSRF対策用トークン発行
        'Core\Controller\Interceptor\Marker\CsrfTokenGenerateAware' => 
            'Core\Controller\Interceptor\CsrfTokenInterceptor',

        //CSRF対策用トークンチェック
        'Core\Controller\Interceptor\Marker\CsrfTokenVerifyAware' => 
            'Core\Controller\Interceptor\CsrfTokenInterceptor',


    ),
    //Console用
    'console' => array(
    ),
);