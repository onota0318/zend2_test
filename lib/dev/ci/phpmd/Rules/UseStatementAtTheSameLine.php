<?php
/**
 *
 * [カスタムルール]
 * 同一行内に複数条件記があるかチェック
 * 
 * PHPUnitのカバレッジ収集単位が行単位の為
 * ⇒このチェックを入れることによって、機械的にC1（分岐網羅）に近づくような・・・
 */
namespace Dev\Ci\Phpmd\Rules;

use PHPMD\AbstractRule;
use PHPMD\AbstractNode;
use PHPMD\Rule\MethodAware;
use PHPMD\Rule\FunctionAware;

class UseStatementAtTheSameLine extends AbstractRule implements MethodAware, FunctionAware
{
    /**
     * メイン
     * @see PHP_PMD_Rule::apply()
     */
    public function apply(AbstractNode $node)
    {
        //if文
        foreach ($node->findChildrenOfType("IfStatement") as $statement) {
            $this->detectedkMuitiIfStatement($statement);
        }

        //switch case文
        foreach ($node->findChildrenOfType("SwitchLabel") as $statement) {
            $this->detectedkMuitiCaseStatement($statement);
        }
    }
    
    /**
     * ifの条件記チェック
     * 
     * @param AbstractNode $node node
     */
    private function detectedkMuitiIfStatement(AbstractNode $node)
    {
        $target = $this->getTargetBlock($node);
        $count  = count($target);
        
        for ($iii = 0; $iii < $count; ++$iii) {
            $line = preg_replace("/(\s|\t|\n|\r)/ui", "", $target[$iii]);

            if (preg_match("/^.+(\|\||\&\&)+.+$/ui", $line)) {
                $this->addViolation($node ,array($node->getBeginLine() + $iii));
            }
        }
    }
    
    /**
     * switch caseの条件記チェック
     * 
     * @param AbstractNode $node node
     */
    private function detectedkMuitiCaseStatement(AbstractNode $node)
    {
        $target = $this->getTargetBlock($node);
        $count  = count($target);
        
        for ($iii = 0; $iii < $count; ++$iii) {

            if (false === stripos($target[$iii], "case")) {
                continue;
            }
            
            //@todo 一行完結式（case hoge: [式]; break;）も排除したい
            if (preg_match("/case.+\:.+case.+\:.*$/ui", $target[$iii])) {
                $this->addViolation($node ,array($node->getBeginLine() + $iii));
                continue;
            }
        }
    }

    /**
     * 対象ブロックの抜出
     * 
     * @param AbstractNode $node node
     * @return array 配列
     */
    private function getTargetBlock(AbstractNode $node)
    {
        $file  = $node->getFileName();
        $start = $node->getBeginLine() - 1;
        $end   = $node->getEndLine() - 1;
        
        $list  = file($file);
        return array_slice($list, $start, ($end - $start));
    }
}