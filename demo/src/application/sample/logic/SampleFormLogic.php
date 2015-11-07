<?php
/**
 * @buief SampleFormロジック
 * @details SampleFormロジック
 * 
 * @since 2014.12
 * @package sample
 */

namespace Sample\Logic;

use Onota0318\Zend2Adapter\Logic\AbstractDomainLogic;
use Onota0318\Exception\InputValidationException;

class SampleFormLogic extends AbstractDomainLogic
{
    /** @var string 苗字 */
    public $first_name;
    
    /** @var string 名前 */
    public $last_name;
    
    /** @var int 性別 */
    public $gender;
    
    /** @var int 都道府県 */
    public $pref;
    
    /**
     * バリデーションを行う。
     */
    public function validate() 
    {
        //エラークラス
        $ve = new InputValidationException();

        //[型制約]---------------------------------------
        $mv = new \Core\Model\MemberValidator($ve);

        //苗字
        $mv->validateFirstName($this->first_name);
        //名前
        $mv->validateLastName($this->last_name);
        //性別
        $mv->validateGender($this->gender);
        //都道府県
        $mv->validatePref($this->pref);
        
        //エラーありなら投げる
        if ($ve->hasErrors()) {
            throw $ve;
        }
    }

    /**
     * {@inheriteDocs}
     */
    public function execute() 
    {
        $this->validate();
    }
}
