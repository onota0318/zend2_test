<?php
/**
 * SampleモジュールTOP
 * 
 * @since 2015/01
 * @package sample
 */
namespace Tests\Sample\Controller\Form;

use Onota0318\Test\TestUtil;
use Onota0318\Environment\AppEnvironment;
use Core\Type\PrefType;
use Core\Type\GenderType;
use Sample\Controller\Form\SampleFormStateHolder;
use Onota0318\Zend2Adapter\Test\FixtureManager;
use Tests\Sample\Fixture\Auth\MemberFixtureRecord;
use Tests\Sample\Controller\AbstractSampleControllerTest;

class StartControllerTest extends AbstractSampleControllerTest
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
     * 
     * @test
     */
    public function test_Form_Start_正常系_アクセス()
    {
        TestUtil::setSystemDateTime("2011/01/01 12:12:12");
        TestUtil::setHttpsRequest();

        //レコード投入
        FixtureManager::load(new MemberFixtureRecord());
        
        //ログイン
        $id = 'hogeID';
        $pw = 'hogePW';
        $identity = $this->authenticate($id, $pw);
            
        //実行
        $this->dispatch('/sample/form/start');
        $controller = $this->getControllerInstance();

        //HTTPステータス
        $this->assertResponseStatusCode(302);

        //認可情報
        $this->assertEquals("1", $identity->id);
        $this->assertEquals("尾野", $identity->first_name);
        $this->assertEquals("テスト", $identity->last_name);
        $this->assertEquals("1",  $identity->gender);
        $this->assertEquals("13", $identity->pref);
        
        //セッション
        $state = $controller->session()->load(SampleFormStateHolder::id());
        $this->assertHashMap(PrefType::getList(), $state->pref_list);
        $this->assertHashMap(GenderType::getList(), $state->gender_list);
        
        //リダイレクト先URL
        $url = AppEnvironment::getInstance()->base_url . "sample/form/input";
        $this->assertRedirectTo($url);
    }
}
