<?php
/**
 * Sampleフォームセッションホルダ
 * 
 * @since 2015/01
 * @package sample
 */
namespace Sample\Controller\Form;

use Onota0318\Holder\AbstractStateHolder;

class SampleFormStateHolder extends AbstractStateHolder
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

    /** @var array エラー情報 */
    protected $errors = array();
}
