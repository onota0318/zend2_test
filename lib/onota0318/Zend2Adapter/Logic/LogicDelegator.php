<?php
/**
 * @buief ビジネスロジック（Service層）実行の処理オブジェクト
 * @details 
 *   まんま実行だと、インターセプトロガーとかサービスロケータみたいな
 *   AOP要素を引き継ぐのに面倒なのと、Zend2のEventManagerを経由して実行させたい為
 *   ※デリゲーターって言ってるけど・・・proxyのような・・・
 * 
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Logic;

use Zend\EventManager\Event;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogicDelegator
{
    /**
     * @var ServiceLocatorInterface ロケーター
     */
    private $locator = null;
    
    /**
     * @var AbstractLogic ロジック
     */
    private $logic = null;
    
    /**
     * @var EventManager イベントマネージャー 
     */
    private $event = null;
    
    /**
     * @var Adapter アダプタ 
     */
    private $adapter = null;
    
    /**
     * @var mixed ロジックの戻り値 
     */
    private $returnedValue = null;
    
    /**
     * コンストラクタ
     * ※通常利用禁止 LogicAbstractFactoryから呼ばれる
     * 
     * @param ServiceLocatorInterface $locator ロケーター
     * @param string $logicName ロジック名
     * @deprecated
     */
    public function __construct(ServiceLocatorInterface $locator, $logicName)
    {
        $this->locator = $locator;
        
        $this->logic   = $this->injectLogic(new $logicName());
        $this->event   = $this->setEvent($locator);
    }
    
    /**
     * logicに必要な情報を注入
     * 
     * @param \Onota0318\Zend2Adapter\Logic\AbstractLogic $logic
     * @return AbstractLogic logic
     */
    protected function injectLogic(AbstractLogic $logic)
    {
        if ($logic instanceof AbstractDomainLogic) {

            $adapter = "default";
            if (property_exists($logic, "useAdapter")) {
                $adapter = $logic->useAdapter;
            }
            
            $this->adapter = $this->locator->get("adapter:" . $adapter);
            $logic->setDbAdapter($this->adapter);
        }
        
        return $logic;
    }
    
    /**
     * イベント設定
     * ここでevent->attachした処理は、__callにトリガがあり、
     * invokeを経由してインターセプトします。
     * 
     * @param ServiceLocatorInterface $locator ロケーター
     * @return EventManager イベントマネージャー
     */
    private function setEvent(ServiceLocatorInterface $locator)
    {
        $em     = $locator->get("EventManager");
        $shared = $locator->get("SharedEventManager");

        $shared->attach(__CLASS__, '*', array($this, 'invoke'), -1);
        $em->setIdentifiers(__CLASS__)->setSharedManager($shared);
        
        return $em;
    }
   
    /**
     * イベント起動
     * ビジネスロジックを実行するのはtrigger経由でinvokeメソッドより
     * 
     * @param string $method メソッド
     * @param array $args 引数
     * @return mixed 戻り値
     */
    public function __call($method, array $args = array())
    {
        $this->returnedValue = null;
        $this->event->trigger(__CLASS__, $method, $args);
        return $this->returnedValue;
    }
    
    /**
     * 値をセットする。
     * 
     * @param string $property プロパティ名
     * @param mixed $value セットする値
     */
    public function __set($property, $value)
    {
        $this->event->trigger(__CLASS__, $property, array($value));
    }

    /**
     * ビジネスロジック実行
     * あらゆるメソッド実行もインターセプトする
     * ※通常利用禁止 EventManager->triggerから呼ばれる
     *
     * @param Event $e イベント
     * @deprecated
     * @throws \Exception
     */
    public function invoke(Event $e)
    {
        //TODO:ロギング
        $member = $e->getTarget();
        $param  = $e->getParams();

        try {
            //メソッドの場合
            if (method_exists($this->logic, $member)) {
                $this->returnedValue = call_user_func_array(array($this->logic, $member), $param);
            }
            
            //プロパティの場合
            elseif (property_exists($this->logic, $member)) {
                $this->logic->$member = $param[0];
            }
        }
        
        //いったん捕捉して必要に応じてロールバック
        catch (\Exception $e) {
            
            if ($this->logic instanceof AbstractDomainLogic) {
                $connection = $this->adapter->getDriver()->getConnection();

                if ($connection->inTransaction()) {
                    $connection->rollback();
                    $connection->commit();
                }
            }
            
            throw $e;
        }
    }
}
