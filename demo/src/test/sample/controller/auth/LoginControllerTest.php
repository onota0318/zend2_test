<?php
/**
 * Sampleモジュール Auth\LoginControllerテスト
 * 
 * @since 2015/01
 * @package sample
 */
namespace Tests\Sample\Controller\Auth;

use Onota0318\Test\TestUtil;
use Tests\Sample\Controller\AbstractSampleControllerTest;
use Onota0318\Holder\ErrorsStateHolder;
use Onota0318\Holder\ErrorsScreenHolder;
use Onota0318\Message\Message;

class LoginControllerTest extends AbstractSampleControllerTest
{
    /**
     * [indexAction]
     * 正常系テスト
     * 
     * @test
     */
    public function test_Login_正常系_アクセス()
    {
        TestUtil::setSystemDateTime("2011/01/01 12:12:12");
        TestUtil::setHttpsRequest();

        //実行
        $this->dispatch('/sample/auth/login');
        
        //HTTPステータス
        $this->assertResponseStatusCode(200); 
        
        //テンプレート名
        $this->assertTemplateName("/auth/login.tpl");
    }

    /**
     * [indexAction]
     * 正常系テスト
     * エラーメッセージあり
     * 
     * @test
     */
    public function test_Login_正常系_エラーメッセージあり()
    {
        TestUtil::setSystemDateTime("2011/02/02 12:12:12");
        TestUtil::setHttpsRequest();

        //セッション
        $sess = $this->startSession();
        $error = $sess->load(ErrorsStateHolder::id());
        $error->errors = array(
            "auth" => (new Message())->setMessage("test"),
        );
        $sess->set($error);
        
        //実行
        $this->dispatch('/sample/auth/login');
        //$controller = $this->getControllerInstance();

        //HTTPステータス
        $this->assertResponseStatusCode(200); 

        //エラー
        $holder = $this->getAssignedData(ErrorsScreenHolder::id());
        $this->assertArrayHasKey("auth", $holder->errors);
        $this->assertEquals("test", $holder->errors["auth"]->getMessage());
        
        //テンプレート名
        $this->assertTemplateName("/auth/login.tpl");
    }
}
