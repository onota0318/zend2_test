<?php
/**
 * Sampleモジュール Auth\AuthenticateControllerテスト
 * 
 * @since 2015/01
 * @package sample
 */
namespace Tests\Sample\Controller\Auth;

use Onota0318\Test\TestUtil;
use Onota0318\Zend2Adapter\Test\FixtureManager;
use Tests\Sample\Fixture\Auth\MemberFixtureRecord;
use Onota0318\Environment\AppEnvironment;
use Tests\Sample\Controller\AbstractSampleControllerTest;

class AuthenticateControllerTest extends AbstractSampleControllerTest
{
    /**
     * セットアップ
     */
    public function setUp()
    {
        parent::setUp();
        
        $adapter = $this->getAdapter('adapter:default');
        FixtureManager::setAdapter($adapter);
    }
    
    /**
     * [indexAction]
     * 正常系テスト
     * 
     * @test
     */
    public function test_Authenticate_正常系_アクセス()
    {
        TestUtil::setSystemDateTime("2011/01/01 12:12:12");
        TestUtil::setHttpsRequest();

        //レコード投入
        FixtureManager::load(new MemberFixtureRecord());
        
        //実行
        $this->dispatch('/sample/auth/authenticate', "POST", array(
            'login_id' => "hogeID",
            'login_pw' => "hogePW",
        ));

        //Controller
        $controller = $this->getControllerInstance();
        
        //HTTPステータス
        $this->assertResponseStatusCode(302);

        //認可情報
        $identity = $controller->authenticate()->getIdentity();
        $this->assertEquals("1", $identity->id);
        $this->assertEquals("hogeID", $identity->login_id);
        $this->assertEquals("2011-01-01 12:12:12", $identity->last_login_date);
        $this->assertEquals("2011-01-01 12:12:12", $identity->created_date);
        $this->assertEquals("2011-01-01 12:12:12", $identity->modified_date);
        $this->assertEmpty($identity->deleted_date);
        $this->assertFalse(isset($identity->login_pw));
        
        //リダイレクト先URL
        $url = AppEnvironment::getInstance()->base_url . "sample/form/start";
        $this->assertRedirectTo($url);
    }

    /**
     * [indexAction]
     * 異常系
     * ログイン失敗
     * 
     * @test
     */
    public function test_Authenticate_異常系_ログイン失敗()
    {
        TestUtil::setSystemDateTime("2012/12/12 12:12:12");
        TestUtil::setHttpsRequest();

        //レコード投入
        FixtureManager::load(new MemberFixtureRecord());
        
        //実行
        $this->dispatch('/sample/auth/authenticate', "POST", array(
            'login_id' => "hogeID",
            'login_pw' => "failerPW",
        ));
        
        //Controller
        $controller = $this->getControllerInstance();
        
        //HTTPステータス
        $this->assertResponseStatusCode(302);
        
        //セッション
        $state = $controller->session()->load(\Onota0318\Holder\ErrorsStateHolder::id());
        $this->assertEquals("認証情報が確認できませんでした。", $state->errors['auth']->getMessage());
        
        //リダイレクト先URL
        $url = AppEnvironment::getInstance()->base_url . "sample/auth/login";
        $this->assertRedirectTo($url);
    }    
}
