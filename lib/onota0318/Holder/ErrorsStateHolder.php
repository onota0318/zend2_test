<?php
/**
 * エラー用セッションホルダ
 * 
 * @since 2015/01
 * @package Onota0318
 */
namespace Onota0318\Holder;


class ErrorsStateHolder extends AbstractStateHolder
{
    /** @var array エラーホルダ */
    protected $errors = array();
}
