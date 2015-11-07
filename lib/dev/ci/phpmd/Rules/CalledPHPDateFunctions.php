<?php
/**
 *
 * [カスタムルール]
 * 日付関数の直接利用
 *
 */
namespace Dev\Ci\Phpmd\Rules;

use Dev\Ci\Phpmd\PmdUtil;
use PHPMD\AbstractRule;
use PHPMD\AbstractNode;
use PHPMD\Rule\MethodAware;
use PHPMD\Rule\FunctionAware;

class CalledPHPDateFunctions extends AbstractRule implements MethodAware, FunctionAware
{
    protected $container = array();

    //日付関数リスト（足りない？？）
    protected $dateFuncList = array(
        "date",
        "time",
        "getdate",
        "gmdate",
        "mktime",
        "date_create"
    );

    //日付クラスリスト
    protected $dateClassList = array(
        "DateTime",
        "DateTimeImmutable",
    );

    /**
     * メイン
     * @see PHP_PMD_Rule::apply()
     */
    public function apply(AbstractNode $node)
    {
        //日付関数チェック
        foreach ($node->findChildrenOfType("FunctionPostfix") as $functions) {
            if (in_array(PmdUtil::excludeNamespace($functions->getImage()), $this->dateFuncList)) {
                $this->collect($node, $functions);
            }
        }

        //日付クラスチェック
        foreach($node->findChildrenOfType("ClassReference") as $classes) {
            if (in_array(PmdUtil::excludeNamespace($classes->getImage()), $this->dateClassList)) {
                $this->collect($node, $classes);
            }
        }

        $this->raise();
    }

    /**
     * PMD警告
     * @param PHP_PMD_AbstractNode $node
     * @param unknown $image
     * @param unknown $line
     */
    private function collect(AbstractNode $node, AbstractNode $current)
    {
        //apply()で渡ってきたオブジェクトを直接addViolationに投げると、
        //class開始位置と検知位置の両方で引っかかる。
        //一旦ココで重複排除をする。
        $this->container[PmdUtil::excludeNamespace($node->getImage())][$current->getImage()] = $current;
    }
   
    /**
     * 警告
     */
    private function raise()
    {
        if (count($this->container) <= 0) {
            return;
        }

        foreach ($this->container as $parent => $child) {
            foreach ($child as $object) {
                $this->addViolation(
                    $object ,array(PmdUtil::excludeNamespace($object->getImage()), $object->getBeginLine())
                );
            }
        }
    }
}