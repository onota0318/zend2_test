<?php /* Smarty version Smarty-3.1.21, created on 2015-02-12 15:19:57
         compiled from "/var/www/cgi-bin/demo/src/application/sample/view/form/confirm.tpl" */ ?>
<?php /*%%SmartyHeaderCode:152784426954dc37e263e322-47263117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22606dec1616471b4cd7fb25ebff7ae921d17b22' => 
    array (
      0 => '/var/www/cgi-bin/demo/src/application/sample/view/form/confirm.tpl',
      1 => 1423719118,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152784426954dc37e263e322-47263117',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_54dc37e2dbb191_19933253',
  'variables' => 
  array (
    'GlobalScreenHolder' => 0,
    'SampleFormScreenHolder' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54dc37e2dbb191_19933253')) {function content_54dc37e2dbb191_19933253($_smarty_tpl) {?><html>
<head>
    <content-type="text/html charset='UTF-8'">
    <title>Sampleフォーム 確認画面</title>
</head>
<body>
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['GlobalScreenHolder']->value->header, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <h1>Sampleフォーム 確認画面</h1>

    <dl>
        <dd>苗字：<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->first_name, ENT_QUOTES, 'UTF-8', true);?>
</dd>
        <dd>&nbsp;</dd>
        <dd>名前：<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->last_name, ENT_QUOTES, 'UTF-8', true);?>
</dd>
        <dd>&nbsp;</dd>
        <dd>性別：<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->getGenderType()->toName(), ENT_QUOTES, 'UTF-8', true);?>
</dd>
        <dd>&nbsp;</dd>
        <dd>都道府県：<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->getPrefType()->toName(), ENT_QUOTES, 'UTF-8', true);?>
</dd>
        <dd>&nbsp;</dd>
        <dd><input type="button" value="　登録　"><input type="button" value="　変更　" onClick="javascript:location.href='/demo/sample/form/input'"></dd>
    </dl>
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['GlobalScreenHolder']->value->footer, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
<?php }} ?>
