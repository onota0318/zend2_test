<?php
/*****************************************************/
/*    R O U T E R    C O U N F I G U R A T I O N     */
/*****************************************************/

return array(
    'routes' => array(

        //デフォルト定義
        'home' => array(

            /* @buief
             * "Literal" ⇒ 固定
             * "Segment" ⇒ 動的
             */
            'type'    => 'Segment',
            'options' => array(
                'route'    => '/demo[/:abstract_factory]',

                'constraints' => array(
                    'abstract_factory' => '.*', 
                ),
                'key_value_delimiter' => '/',
                'param_delimiter' => '/',

                'defaults' => array(
                    '__NAMESPACE__' => 'Demo\Controller',
                    'controller'    => 'Index',
                    'action'        => 'index',
                ),
            ),

            'may_terminate' => true,
/*
            'child_routes' => array(
                'wildcard' => array(
                    'type' => 'Zend\Mvc\Router\Http\Wildcard',
                    'options' => array(
                        'key_value_delimiter' => '/',
                        'param_delimiter' => '/',
                    ),
                    'may_terminate' => true,
                ),
            ),
*/
        ),
    ),
);
