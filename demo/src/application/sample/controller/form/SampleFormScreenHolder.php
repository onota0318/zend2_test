<?php
/**
 * Sampleフォーム用Viewホルダ
 * 
 * @since 2015/01
 * @package sample
 */
namespace Sample\Controller\Form;

use Onota0318\Holder\AbstractScreenHolder;
use Core\Type\PrefType;
use Core\Type\GenderType;

class SampleFormScreenHolder extends AbstractScreenHolder
{
    /** @var string 苗字 */
    protected $first_name;

    /** @var string 名前 */
    protected $last_name;

    /** @var int 性別 */
    protected $gender;

    /** @var int 都道府県 */
    protected $pref;
    
    /** @var array 性別一覧 */
    protected $gender_list = array();    
    
    /** @var array 都道府県 */
    protected $pref_list = array();
    
    /**
     * セッション情報を流し込む
     * @param SampleFormStateHolder $state セッション情報
     */
    public function loadState(SampleFormStateHolder $state)
    {
        //入力値系
        $this->first_name = $state->first_name;
        $this->last_name  = $state->last_name;
        $this->gender     = $state->gender;
        $this->pref       = $state->pref;

        //マスタ系
        $this->pref_list    = $state->pref_list;
        $this->gender_list  = $state->gender_list;
    }
    
    /**
     * 都道府県をオブジェクトで返却
     * 
     * @return PrefType 都道府県列挙
     */
    public function getPrefType()
    {
        return new PrefType($this->pref);
    }

    /**
     * 性別をオブジェクトで返却
     * 
     * @return GenderType 性別列挙
     */
    public function getGenderType()
    {
        return new GenderType($this->gender);
    }
}
