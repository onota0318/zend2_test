<?php /* Smarty version Smarty-3.1.21, created on 2015-01-08 13:51:41
         compiled from "/var/www/cgi-bin/demo,zend/src/application/sample/view/index/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:159238276454aa4b512a04a9-92150876%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55764a70cbc94a421fc29b473bc095b0aede633d' => 
    array (
      0 => '/var/www/cgi-bin/demo,zend/src/application/sample/view/index/index.tpl',
      1 => 1420693101,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '159238276454aa4b512a04a9-92150876',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_54aa4b51576ba3_15355243',
  'variables' => 
  array (
    'this' => 0,
    'IndexScreenHolder' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54aa4b51576ba3_15355243')) {function content_54aa4b51576ba3_15355243($_smarty_tpl) {?><html>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['this']->value->url('sample'), ENT_QUOTES, 'UTF-8', true);?>

<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['IndexScreenHolder']->value->hoge, ENT_QUOTES, 'UTF-8', true);?>

<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['IndexScreenHolder']->value->datetime, ENT_QUOTES, 'UTF-8', true);?>

</html><?php }} ?>
