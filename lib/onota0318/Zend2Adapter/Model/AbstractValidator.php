<?php
/**
 * @buief Modelバリデータ
 * @details Modelバリデータ基底クラス
 * 
 * @since 2014.12
 * @package Onota0318
 */
namespace Onota0318\Zend2Adapter\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Onota0318\Exception\InputValidationException;
use Onota0318\Message\Message;

abstract class AbstractValidator
{
    /**
     * @var InputValidationException エラー管理 
     */
    protected $e = null;
    
    /**
     * @var boolean メッセージのコード変換モード
     */
    private $isMessageFromCode = false;
    
    /**
     * @var array デフォルトの文字玉
     */
    protected $defaultMessages = array(
        "IS_EMPTY"     => "[%s]必須です。",
        "TOO_SHORT"    => "[%s]%s文字以上で入力してください。",
        "TOO_LONG"     => "[%s]%s文字以上%s文字以内で入力してください。",
        "OUT_OF_TYPE"  => "[%s]受け付けできない範囲です。",
        "OUT_OF_CHAR"  => "[%s]使用できない文字が含まれています。",
    );
    
    /**
     * コンストラクタ
     * 
     * @param InputValidationException $e エラー管理 
     */
    public function __construct(InputValidationException $e)
    {
        $this->e = $e;
    }
    
    /**
     * メッセージをコード変換モードにする。
     * @return void
     */
    public function enableMessageFromCode()
    {
        $this->isMessageFromCode = true;
    }

    /**
     * メッセージを直接挿入モードにする。（デフォルト）
     * @return void
     */
    public function disableMessageFromCode()
    {
        $this->isMessageFromCode = false;
    }
    
    /**
     * 検証を行う
     * 
     * @param string $field フィールド名
     * @param mixed $value 値
     * @param array $validator バリデータ
     * @param boolean $nullable null許可？
     * @param array $format フォーマット
     * @return void
     */
    protected function verify($field, $value, array $validator, $nullable, array $format = array())
    {
        //空文字判断だけど・・・
        if ($nullable
                && strlen($value) <= 0) {
            return;
        }
        
        $filter  = new InputFilter();
        $factory = new InputFactory();
        
        $filter->add($factory->createInput($validator));
        if ($filter->setData(array($field => $value))->isValid()) {
            return;
        }

        foreach ($filter->getInvalidInput() as $error) {
            $this->addErrors($field, $error->getMessages(), $format);
        }
    }
    
    /**
     * エラー情報を追加
     * 
     * @param string $field フィールド
     * @param array $errors エラーメッセージ
     * @param array $formats フォーマッタ
     */
    protected function addErrors($field, array $errors, array $formats = array())
    {
        foreach ($errors as $error) {
            $message = new Message();

            //コードとして扱う場合
            if ($this->isMessageFromCode) {
                $message->setCode($error);
            } 
            //メッセージとして扱う場合
            else {
                $message->setMessage($error);
            }
            
            $message->setFormat($formats);
            $this->e->addMessage($field, $message);
        }
    }

    /**
     * Not Empty用の定義を取得
     * 
     * @param array $messages メッセージ配列
     * @return array 定義
     */
    protected function getNotEmptySignature(array $messages = array())
    {
        if (count($messages) <= 0) {
            $messages = array(
                \Zend\Validator\NotEmpty::IS_EMPTY => $this->defaultMessages["IS_EMPTY"],
                \Zend\Validator\NotEmpty::INVALID  => $this->defaultMessages["OUT_OF_TYPE"]
            );
        }
        
        return array(
            'name' => 'NotEmpty',
            'options' => array(
                'messages' => $messages
            ),
            'break_chain_on_failure' => true,
        );
    }

    /**
     * 数値用の定義を取得
     * 
     * @param array $messages メッセージ配列
     * @return array 定義
     */
    protected function getDigitsSignature(array $messages = array())
    {
        if (count($messages) <= 0) {
            $messages = array(
                \Zend\Validator\Digits::NOT_DIGITS   => $this->defaultMessages["OUT_OF_TYPE"],
                \Zend\Validator\Digits::STRING_EMPTY => $this->defaultMessages["IS_EMPTY"],
                \Zend\Validator\Digits::INVALID      => $this->defaultMessages["OUT_OF_TYPE"],
            );
        }

        return array(
            'name'    => 'Digits',
            'options' => array(
                'messages' => $messages,
            ),
            'break_chain_on_failure' => true,
        );
    }
    
    /**
     * StringLength用の定義を取得
     * 
     * @param integer $min 最低長
     * @param integer $max 最大長
     * @param array $messages メッセージ配列
     * @return array 定義
     */
    protected function getStringLengthSignature($min = 0, $max = 65536, array $messages = array())
    {
        if (count($messages) <= 0) {
            $messages = array(
                \Zend\Validator\StringLength::INVALID   => $this->defaultMessages["OUT_OF_TYPE"],
                \Zend\Validator\StringLength::TOO_SHORT => $this->defaultMessages["TOO_SHORT"],
                \Zend\Validator\StringLength::TOO_LONG  => $this->defaultMessages["TOO_LONG"],
            );
        }
        
        return array(
            'name'    => 'StringLength',
            'options' => array(
                'min'      => $min,
                'max'      => $max,
                'messages' => $messages,
            ),
            'break_chain_on_failure' => true,
        );
    }
    
    /**
     * 不正文字用の定義を取得
     * 
     * @param array $messages メッセージ配列
     * @return array 定義
     */
    protected function getUnsupportedStringSignature(array $messages = array())
    {
        if (count($messages) <= 0) {
            $messages = array(
                \Zend\Validator\Callback::INVALID_CALLBACK => $this->defaultMessages['OUT_OF_TYPE'],
                \Zend\Validator\Callback::INVALID_VALUE    => $this->defaultMessages['OUT_OF_CHAR'],
            );
        }
        
        return array(
            'name' => 'callback',
            'options' => array(
                'callback' => function($value) {
                    return !\Onota0318\Library\StringConverter::hasGaiji($value)
                        && !\Onota0318\Library\StringConverter::hasSurrogatePair($value);
                },
                'messages' => $messages,
            ),
            'break_chain_on_failure' => true,
        ); 
    }
}
