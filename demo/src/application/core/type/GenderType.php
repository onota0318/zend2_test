<?php
/**
 * 性別の列挙
 * 
 * @since 2014.12
 * @package core
 */
namespace Core\Type;

use Onota0318\Type\AbstractType;
use Onota0318\Type\HashMapInterface;

class GenderType extends AbstractType implements HashMapInterface
{
    /**
     * @var int 「男性」
     */
    const MAN = 1;
    
    /**
     * @var int 「女性」
     */
    const WOMAN = 2;

    /**
     * @var int 未回答
     */
    const SECRET = 3;
    
    /**
     * @var array 性別リスト 
     */
    private static $genderList = array(
        self::MAN    => "男性",
        self::WOMAN  => "女性",
        self::SECRET => "未回答",
    );
    
    /**
     * 都道府県名に変換
     * 
     * @return string 性別一覧
     */
    public function toName()
    {
        if (!isset(self::$genderList[$this->valueOf()])) {
            return "";
        }

        return self::$genderList[$this->valueOf()];
    }
    
    /**
     * 一覧を取得
     * 
     * @return array 性別一覧
     */
    public static function getList()
    {
        return self::$genderList;
    }    
    
    /**
     * デフォルト
     * @throws \InvalidArgumentException
     */
    protected function __default() 
    {
        throw new \InvalidArgumentException(
            "定義されている値ではありません"
        );
    }
}
