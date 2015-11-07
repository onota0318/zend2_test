<?php
/**
 * 「はい」「いいえ」の列挙
 *  tinyint(1)のフラグにも使う
 * 
 * @since 2014.12
 * @package Onota0318
 */
namespace Core\Type;

use Onota0318\Type\AbstractType;

class YesNoType extends AbstractType
{
    /**
     * @var int 「はい」
     */
    const YES = 1;
    
    /**
     * @var int 「いいえ」
     */
    const NO = 0;
    
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
