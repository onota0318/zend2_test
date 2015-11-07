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
use Core\Type\PrefType;
use Core\Type\GenderType;
use Onota0318\Environment\AppEnvironment;
use Onota0318\Zend2Adapter\Test\FixtureManager;
use Tests\Sample\Fixture\Auth\MemberFixtureRecord;
use Tests\Sample\Controller\AbstractSampleControllerTest;

class ConfirmControllerTest extends AbstractSampleControllerTest
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
     * 入力値エラーなし
     * 
     * @test
     */
    public function test_Form_Confirm_正常系_入力値エラーなし()
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
        $this->dispatch('/sample/form/confirm', 'POST', array(
            'first_name' => 'おの',
            'last_name'  => 'テスト',
            'gender'     => '3',
            'pref'       => '2',
        ));
        
        $controller = $this->getControllerInstance();

        //HTTPステータス
        $this->assertResponseStatusCode(200);

        //セッション
        $state = $controller->session()->load(SampleFormStateHolder::id());
        $this->assertEquals("おの", $state->first_name);
        $this->assertEquals("テスト", $state->last_name);
        $this->assertEquals("3", $state->gender);
        $this->assertEquals("2", $state->pref);
        $this->assertEmpty($state->errors);
        
        //ScreenHolder
        $holder = $this->getAssignedData(SampleFormScreenHolder::id());
        $this->assertEquals("おの", $holder->first_name);
        $this->assertEquals("テスト", $holder->last_name);
        $this->assertEquals("3", $holder->gender);
        $this->assertEquals("2", $holder->pref);
        $this->assertEquals(PrefType::AOMORI()->toName(), $holder->getPrefType()->toName());
        $this->assertEquals(GenderType::SECRET()->toName(), $holder->getGenderType()->toName());
        
        //テンプレ
        $this->assertTemplateName("/form/confirm.tpl");
    }

    /**
     * [indexAction]
     * 異常系テスト
     * 入力値エラー
     * 
     * エラーをセッションに詰めて、
     * inputに遷移する
     * 
     * @test
     */
    public function test_Form_Confirm_異常系_入力値エラー()
    {
        TestUtil::setSystemDateTime("2011/02/02 22:22:22");
        TestUtil::setHttpsRequest();

        //レコード投入
        FixtureManager::load(new MemberFixtureRecord());
        
        //ログイン
        $id = 'hogeID';
        $pw = 'hogePW';
        $this->authenticate($id, $pw);
            
        //実行
        $this->dispatch('/sample/form/confirm', 'POST', array(
            'first_name' => 'おの①',        //外字
            'last_name'  => '',             //未入力
            'gender'     => 'A',            //数字じゃない
            'pref'       => '48',           //範囲外
        ));
        
        $controller = $this->getControllerInstance();

        //HTTPステータス
        $this->assertResponseStatusCode(302);

        //リダイレクト先URL
        $url = AppEnvironment::getInstance()->base_url . "sample/form/input";
        $this->assertRedirectTo($url);

        //セッション
        $state = $controller->session()->load(SampleFormStateHolder::id());
        $this->assertEquals("おの〓", $state->first_name);
        $this->assertEquals("", $state->last_name);
        $this->assertEquals("A", $state->gender);
        $this->assertEquals("48", $state->pref);

        //エラーメッセージ
        $error = $state->errors;
        $this->assertArrayHasKey('first_name', $error);
        $this->assertEquals('[苗字]使用できない文字が含まれています。', $error['first_name']->getMessage());

        $this->assertArrayHasKey('last_name', $error);
        $this->assertEquals('[名前]必須です。', $error['last_name']->getMessage());

        $this->assertArrayHasKey('gender', $error);
        $this->assertEquals('[性別]受け付けできない範囲です。', $error['gender']->getMessage());
        
        $this->assertArrayHasKey('pref', $error);
        $this->assertEquals('[都道府県]受け付けできない範囲です。', $error['pref']->getMessage());
    }
}
