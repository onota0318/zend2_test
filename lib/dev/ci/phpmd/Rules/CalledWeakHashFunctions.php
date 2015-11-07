<?php
/**
 *
 * [カスタムルール]
 * 弱いhash関数利用
 *
 */
namespace Dev\Ci\Phpmd\Rules;

use Dev\Ci\Phpmd\PmdUtil;
use PHPMD\AbstractRule;
use PHPMD\AbstractNode;
use PHPMD\Rule\MethodAware;
use PHPMD\Rule\FunctionAware;

class CalledWeakHashFunctions extends AbstractRule implements MethodAware, FunctionAware
{
    private $container = array();

    //関数リスト（足りない？？）
    protected $weakHashFuncList = array(
        "sha1",
        "md5",
        "hash"
    );

    /**
     * メイン
     * @see PHP_PMD_Rule::apply()
     */
    public function apply(AbstractNode $node)
    {
        //日付関数チェック
        foreach ($node->findChildrenOfType("FunctionPostfix") as $functions) {

            if (in_array(PmdUtil::excludeNamespace($functions->getImage()), $this->weakHashFuncList)) {
                if ($this->hasWeakHashAlgolism($functions)) {
                    $this->collect($node, $functions);
                }
            }
        }

        $this->raise();
    }

    /**
     *
     */
    private function hasWeakHashAlgolism(AbstractNode $functions)
    {
        $list  = file($functions->getFileName());
        $start = $functions->getBeginLine() - 1;
        $end   = $functions->getEndLine() - 1;

        $target = "";
        for ($iii = $start; $iii <= $end; ++$iii) {
            $target .= $list[$iii];
        }

        if (PmdUtil::excludeNamespace($functions->getImage()) === "hash") {

            if (false !== mb_eregi("(sha1|md5)+", $target)) {
                return true;
            }

            return false;
        }

        return true;
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
        $this->container[$node->getImage()][$current->getImage()] = $current;
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
                $this->addViolation($object
                        ,array(PmdUtil::excludeNamespace($object->getImage())
                                ,$object->getBeginLine()));
            }
        }
    }
}