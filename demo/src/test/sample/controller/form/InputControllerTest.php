<?php
/**
 * SampleモジュールTOP
 * 
 * @since 2015/01
 * @package sample
 */
namespace Tests\Sample\Controller\Form;

use Onota0318\Test\TestUtil;
use Onota0318\Message\Message;
use Sample\Controller\Form\SampleFormStateHolder;
use Sample\Controller\Form\SampleFormScreenHolder;
use Onota0318\Holder\ErrorsScreenHolder;
use Onota0318\Zend2Adapter\Test\FixtureManager;
use Tests\Sample\Fixture\Auth\MemberFixtureRecord;
use Tests\Sample\Controller\AbstractSampleControllerTest;

class InputControllerTest extends AbstractSampleControllerTest
{
    /**
     * セットアップ
     */
    public function setUp()
    {
        parent::setUp();
        FixtureManager::setAdapter($this->getAdapter('adapter:default'));
    }
    
    /**
     * [indexAction]
     * 正常系テスト
     * セッションなしの状態
     * 
     * @test
     */
    public function test_Form_Input_正常系_セッションなし()
    {
        TestUtil::setSystemDateTime("2011/01/01 12:12:12");
        TestUtil::setHttpsRequest();

        //レコード投入
        FixtureManager::load(new MemberFixtureRecord());
        
        //ログイン
        $id = 'hogeID';
        $pw = 'hogePW';
        $this->authenticate($id, $pw);
            
        //実行
        $this->dispatch('/sample/form/input');
        //$controller = $this->getControllerInstance();

        //HTTPステータス
        $this->assertResponseStatusCode(200);

        //ScreenHolder
        $holder = $this->getAssignedData(SampleFormScreenHolder::id());
        $this->assertEmpty($holder->first_name);
        $this->assertEmpty($holder->last_name);
        $this->assertEmpty($holder->gender);
        $this->assertEmpty($holder->pref);
        
        //エラー
        $error = $this->getAssignedData(ErrorsScreenHolder::id());
        $this->assertEmpty($error->errors);
        
        //テンプレ
        $this->assertTemplateName("/form/input.tpl");
    }

    /**
     * [indexAction]
     * 正常系テスト
     * セッションありの状態
     * 
     * @test
     */
    public function test_Form_Input_正常系_セッションあり()
    {
        TestUtil::setSystemDateTime("2011/02/02 22:22:22");
        TestUtil::setHttpsRequest();

        //レコード投入
        FixtureManager::load(new MemberFixtureRecord());

        //セッション登録
        $sess  = $this->startSession();
        $state = $sess->load(SampleFormStateHolder::id());
        $state->first_name = "おの";
        $state->last_name  = "テスト";
        $state->gender     = "3";
        $state->pref       = "2";
        $state->errors     = array('pref' => (new Message())->setMessage("test"));
        $sess->set($state);
        
        //ログイン
        $id = 'hogeID';
        $pw = 'hogePW';
        $this->authenticate($id, $pw);
            
        //実行
        $this->dispatch('/sample/form/input');
        //$controller = $this->getControllerInstance();

        //HTTPステータス
        $this->assertResponseStatusCode(200);

        //ScreenHolder
        $holder = $this->getAssignedData(SampleFormScreenHolder::id());
        $this->assertEquals("おの", $holder->first_name);
        $this->assertEquals("テスト", $holder->last_name);
        $this->assertEquals("3", $holder->gender);
        $this->assertEquals("2", $holder->pref);
        
        //エラー
        $error = $this->getAssignedData(ErrorsScreenHolder::id());
        $this->assertArrayHasKey("pref", $error->errors);
        $this->assertEquals("test", $error->errors['pref']->getMessage());
        
        //テンプレ
        $this->assertTemplateName("/form/input.tpl");
    }
}
