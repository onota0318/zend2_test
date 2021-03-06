<?php
/**
 * @buief
 * @details MemberAttributesValidator.
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

class MemberAttributesValidator extends AbstractValidator
{
    /**
     * validate for member_id 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateMemberId($input, array $messages = array())
    {
        $logical  = "会員ID";
        $field    = "member_id";
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
     * validate for key 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateKey($input, array $messages = array())
    {
        $logical  = "属性名";
        $field     = "key";
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
     * validate for value 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateValue($input, array $messages = array())
    {
        $logical  = "属性値";
        $field     = "value";
        $nullable  = true;
        $minLength = 0;
        $maxLength = 255;

        $validator = array(
            "name"       => $field,
            "required"   => true,
            "validators" => array(
                $this->getStringLengthSignature($minLength, $maxLength, $messages),
                $this->getUnsupportedStringSignature($messages),
            ),
        );

        $this->verify($field, $input, $validator, $nullable, array($logical, $minLength, $maxLength));
    }

    /**
     * validate for deleted_date 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateDeletedDate($input, array $messages = array())
    {
    }

    /**
     * validate for created_date 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateCreatedDate($input, array $messages = array())
    {
    }

    /**
     * validate for modified_date 
     * 
     * @param mixed $input target value.
     * @param array $messages message list.
     * @return void
     */
    public function validateModifiedDate($input, array $messages = array())
    {
    }

}