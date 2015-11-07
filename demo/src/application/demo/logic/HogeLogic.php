<?php
/**
 * @buief デモ
 * @details デモ
 * 
 * @since 2014.12
 * @package Onota0318
 */

namespace Demo\Logic;

use Onota0318\Zend2Adapter\Logic\AbstractDomainLogic;
use Onota0318\Exception\InputValidationException;

class HogeLogic extends AbstractDomainLogic
{
    public $id = 0;
    public $detail = "";
    
    /**
     * {@inheriteDocs}
     */
    public function validate() 
    {
        $ve = new InputValidationException();

        //型制約
        $idv = new \Core\Model\ItemDetailValidator($ve);
        $idv->validateItemId($this->id);
        $idv->validateDetail($this->detail);
        
        if ($ve->hasErrors()) {
            throw $ve;
        }
        
        //論理制約
        
    }

    /**
     * {@inheriteDocs}
     */
    public function execute() 
    {
        $this->validate();
        
        $table = $this->getTable('Core\Model\ItemDetailTable');
        
        $entity = $table->findById("id", 1);
        var_dump($entity->detail, $entity->getItemEntity()->name);exit;
        //$res = $table->loadNewEntity();

    }
}
