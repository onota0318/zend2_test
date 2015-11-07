<?php
/**
 * SampleモジュールTOP
 * 
 * @since 2015/01
 * @package sample
 */
namespace Tests\Sample\Controller;

use Onota0318\Test\TestUtil;
use Onota0318\Environment\AppEnvironment;

class IndexControllerTest extends AbstractSampleControllerTest
{
    /**
     * [indexAction]
     * 正常系テスト
     * 
     * @test
     */
    public function test_正常系_アクセス()
    {
        TestUtil::setSystemDateTime("2011/01/01 12:12:12");
        TestUtil::setHttpsRequest();

        //実行
        $this->dispatch('/sample/');
        
        //HTTPステータス
        $this->assertResponseStatusCode(302);
        
        //リダイレクト先URL
        $url = AppEnvironment::getInstance()->base_url . "sample/auth/login";
        $this->assertRedirectTo($url);
    }
    
    /**
     * [indexAction]
     * 異常系テスト
     * [振舞]
     * HTTPでアクセス
     * [期待値]
     * HttpsOnlyInterceptorにて
     * Onota0318\Exception\NotFoundException発生
     * 
     * @test
     */
    public function test_異常系_HTTPSではない()
    {
        //実行
        $this->dispatch('/sample/');

        //例外
        $location  = "Core\Controller\Interceptor\HttpsOnlyInterceptor";
        $exception = "Onota0318\Exception\NotFoundException";
        $this->assertMvcEventException($location, $exception);
        
        //HTTPステータス
        $this->assertResponseStatusCode(404);
    }
}
