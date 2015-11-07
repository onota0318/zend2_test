<?php
/*****************************************************/
/*    R O U T E R    C O U N F I G U R A T I O N     */
/*****************************************************/

return array(
    'routes' => array(
        'sample' => array(
            'type'    => 'Literal',
            'options' => array(
                'route'    => '/sample',
                'defaults' => array(
                    '__NAMESPACE__' => 'Sample\Controller',
                    'controller'    => 'Index',
                    'action'        => 'index',
                ),
            ),

            'may_terminate' => true,

            'child_routes' => array(
                'child' => array(
                    'type'    => 'Segment',
                    'options' => array(
                        'route'    => '/[:abstract_factory]',
                        'constraints' => array(
                            'abstract_factory' => '.*', 
                        ),
                        'key_value_delimiter' => '/',
                        'param_delimiter' => '/',
                    ),
                ),
            ),
        ),
    ),
);
