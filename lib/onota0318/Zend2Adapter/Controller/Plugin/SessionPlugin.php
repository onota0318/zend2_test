<?php
/**
 * @buief セッション管理用プラグイン
 * @details セッション管理用プラグイン
 *
 * @package Onota0318
 * @since 2014.12
 */

namespace Onota0318\Zend2Adapter\Controller\Plugin;

use Zend\Session\AbstractManager;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Onota0318\Holder\AbstractStateHolder;
use Onota0318\Library\UserAgentNavigator;
use Onota0318\Environment\AppEnvironment;

class SessionPlugin extends AbstractPlugin
{
    /**
     * @var array コンテナリスト 
     */
    private $containerList = array();

    /**
     * @var AbstractManager セッションマネージャー 
     */
    private $manager = null;
    
    /**
     * セッションマネージャーをセットする。
     * 
     * @param AbstractManager $manager セッションマネージャー
     */
    public function setManager(AbstractManager $manager)
    {
        $this->manager = $manager;
    }
    
    /**
     * セッションマネージャーを取得する。
     * 
     * @return AbstractManager $manager セッションマネージャー
     */
    public function getManager()
    {
        if ($this->manager === null) {
            throw new \LogicException(
                "セッションインターセプタ経由で取得してください。"
            );
        }
        
        return $this->manager;
    }
    
    /**
     * セッションデータが有効か？
     * 
     * @return boolean
     */
    public function exists()
    {
        return $this->getManager()->sessionExists();
    }
    
    /**
     * セッションIDを更新
     * 
     * @return void
     */
    public function regenerateId()
    {
        /* @buief
         * UnitTest中にsession_regenerate_id()を実行すると
         * テストが落ちてしまう為、苦肉の策の対応。
         */
        if (AppEnvironment::getInstance()->isUnitTest()) {
            return;
        }
        
        $this->getManager()->regenerateId();
    }
    
    /**
     * コンテナにデータが存在するか？
     * 
     * @param string $holderName ホルダ名
     * @return boolean
     */
    public function has($holderName)
    {
        $container = $this->factoryContainer($holderName);
        return isset($container->$holderName);
    }
    
    /**
     * セッションIDを取得する
     */
    public function getId()
    {
        return $this->getManager()->getId();
    }
    
    /**
     * セッションデータを取得する
     * 
     * @param string $holderName ホルダ名
     * @return AbstractStateHolder ホルダ
     */
    public function load($holderName)
    {
        if ($this->has($holderName)) {
            return $this->factoryContainer($holderName)->$holderName;
        }
        
        return new $holderName();
    }
   
    /**
     * 
     * @param AbstractStateHolder $holder
     */
    public function set(AbstractStateHolder $holder)
    {
        $holderName = $holder::id();
        $container  = $this->factoryContainer($holderName);
        $container->$holderName = $holder;
    }
    
    /**
     * セッションデータを破棄する
     * 
     * @param string $holderName ホルダ名
     */
    public function remove($holderName)
    {
        $this->getManager()->getStorage()->clear($holderName);
    }
    
    /**
     * セッションデータを全破棄する
     * 
     * @param array $options オプション
     */
    public function destroy(array $options = array())
    {
        $options["clear_storage"] = true;

        if (!UserAgentNavigator::isFeaturePhone()) {
            $options["send_expire_cookie"] = true;
        }
        
        $this->getManager()->destroy($options);
    }
    
    /**
     * コンテナを作成する。
     * 一度作成したら同じオブジェクトを返却する様にキャッシュする
     * 
     * @param string $holderName ホルダ名
     * @return Container コンテナ
     */
    private function factoryContainer($holderName)
    {
        if (!isset($this->containerList[$holderName])) {
            $this->containerList[$holderName] = new \Zend\Session\Container($holderName);
        }
        
        return $this->containerList[$holderName];
    }
}
