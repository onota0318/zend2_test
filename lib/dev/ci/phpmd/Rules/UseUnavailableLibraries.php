<?php
/**
 *
 * [カスタムルール]
 * ライブラリ禁止メソッドを使用
 *
 */
namespace Dev\Ci\Phpmd\Rules;

use PHPMD\AbstractRule;
use PHPMD\AbstractNode;
use PHPMD\Rule\ClassAware;
use PHPMD\Rule\MethodAware;
use PHPMD\Rule\FunctionAware;

class UseUnavailableLibraries extends AbstractRule implements ClassAware, MethodAware, FunctionAware
{
    protected $container = array();

    //使用禁止クラスリスト
    //入れ子でメソッドを定義
    protected $classList = array(
        "\Onota0318\Library\Provider\SystemDateProvider" => array(
            "setSystemDateTime",
        ),
    );


    /**
     * メイン
     * @see PHP_PMD_Rule::apply()
     */
    public function apply(AbstractNode $node)
    {
        $clazzList = array_keys($this->classList);

        foreach ($node->findChildrenOfType("ClassOrInterfaceReference") as $classes) {

            if (in_array($classes->getImage(), $clazzList)) {

                foreach ($classes->getParent()->findChildrenOfType("MethodPostfix") as $methods) {

                    if (in_array($methods->getImage(), $this->classList[$classes->getImage()])) {
                        $this->collect($node, $classes, $methods);
                    }

                }
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
    private function collect(AbstractNode $node, AbstractNode $current, AbstractNode $method)
    {
        //apply()で渡ってきたオブジェクトを直接addViolationに投げると、
        //class開始位置と検知位置の両方で引っかかる。
        //一旦ココで重複排除をする。
        $this->container[$node->getImage()][$current->getImage()."::".$method->getImage()] = $current;
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

            foreach ($child as $key => $object) {
                $this->addViolation(
                    $object ,array($object->getImage() ,$object->getBeginLine(), $key)
                );
            }
        }
    }
}