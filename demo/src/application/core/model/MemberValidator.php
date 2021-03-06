<?php
/**
 * @buief
 * @details MemberValidator.
 *
 * Generated By DaoGenerator.
 * 
 * TODO:※スケルトンです。適切に修正してください。
 *
 * @since 2015/02/13
 * @package Onota0318
 */
namespace Core\Model;
 
use Onota0318\Zend2Adapter\Model\AbstractValidator;

class MemberValidator extends AbstractValidator
{
    /**
     * validate for id 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateId($input, array $messages = array())
    {
        $logical  = "会員ID";
        $field    = "id";
        $nullable = false;

        $validator = array(
            "name"       => $field,
            "required"   => true,
            "validators" => array(
                $this->getNotEmptySignature($messages),
                $this->getDigitsSignature($messages),
            ),
        );

        $this->verify($field, $input, $validator, $nullable, array($logical));
    }

    /**
     * validate for login_id 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateLoginId($input, array $messages = array())
    {
        $logical  = "ログインID";
        $field     = "login_id";
        $nullable  = false;
        $minLength = 0;
        $maxLength = 255;

        $validator = array(
            "name"       => $field,
            "required"   => true,
            "validators" => array(
                $this->getNotEmptySignature($messages),
                $this->getStringLengthSignature($minLength, $maxLength, $messages),
                $this->getUnsupportedStringSignature($messages),
            ),
        );

        $this->verify($field, $input, $validator, $nullable, array($logical, $minLength, $maxLength));
    }

    /**
     * validate for password 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validatePassword($input, array $messages = array())
    {
        $logical  = "パスワード";
        $field     = "password";
        $nullable  = false;
        $minLength = 0;
        $maxLength = 255;

        $validator = array(
            "name"       => $field,
            "required"   => true,
            "validators" => array(
                $this->getNotEmptySignature($messages),
                $this->getStringLengthSignature($minLength, $maxLength, $messages),
                $this->getUnsupportedStringSignature($messages),
            ),
        );

        $this->verify($field, $input, $validator, $nullable, array($logical, $minLength, $maxLength));
    }

    /**
     * validate for first_name 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateFirstName($input, array $messages = array())
    {
        $logical  = "苗字";
        $field     = "first_name";
        $nullable  = false;
        $minLength = 0;
        $maxLength = 255;

        $validator = array(
            "name"       => $field,
            "required"   => true,
            "validators" => array(
                $this->getNotEmptySignature($messages),
                $this->getStringLengthSignature($minLength, $maxLength, $messages),
                $this->getUnsupportedStringSignature($messages),
            ),
        );

        $this->verify($field, $input, $validator, $nullable, array($logical, $minLength, $maxLength));
    }

    /**
     * validate for last_name 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateLastName($input, array $messages = array())
    {
        $logical  = "名前";
        $field     = "last_name";
        $nullable  = false;
        $minLength = 0;
        $maxLength = 255;

        $validator = array(
            "name"       => $field,
            "required"   => true,
            "validators" => array(
                $this->getNotEmptySignature($messages),
                $this->getStringLengthSignature($minLength, $maxLength, $messages),
                $this->getUnsupportedStringSignature($messages),
            ),
        );

        $this->verify($field, $input, $validator, $nullable, array($logical, $minLength, $maxLength));
    }

    /**
     * validate for gender 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateGender($input, array $messages = array())
    {
        $logical  = "性別";
        $field    = "gender";
        $nullable = false;

        $validator = array(
            "name"       => $field,
            "required"   => true,
            "validators" => array(
                $this->getNotEmptySignature($messages),
                $this->getDigitsSignature($messages),
                
                array(
                    'name' => 'callback',
                    'options' => array(
                        'callback' => function($value) {
                            return \Core\Type\GenderType::has($value);
                        },
                        'messages' => array(
                            \Zend\Validator\Callback::INVALID_VALUE 
                                => $this->defaultMessages['OUT_OF_TYPE']
                        ),
                    ),
                    'break_chain_on_failure' => true,                
                ),
            ),
        );

        $this->verify($field, $input, $validator, $nullable, array($logical));
    }

    /**
     * validate for pref 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validatePref($input, array $messages = array())
    {
        $logical  = "都道府県";
        $field    = "pref";
        $nullable = false;

        $validator = array(
            "name"       => $field,
            "required"   => true,
            "validators" => array(
                $this->getNotEmptySignature($messages),
                $this->getDigitsSignature($messages),
                array(
                    'name' => 'callback',
                    'options' => array(
                        'callback' => function($value) {
                            return \Core\Type\PrefType::has($value);
                        },
                        'messages' => array(
                            \Zend\Validator\Callback::INVALID_VALUE 
                                => $this->defaultMessages['OUT_OF_TYPE']
                        ),
                    ),
                    'break_chain_on_failure' => true,                
                ),
            ),
        );
        $this->verify($field, $input, $validator, $nullable, array($logical));
    }
}