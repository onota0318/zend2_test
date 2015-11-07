<?php /* Smarty version Smarty-3.1.21, created on 2015-02-09 14:29:17
         compiled from "/var/www/cgi-bin/demo/src/application/sample/view/auth/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21025855354cee31ef21144-43201344%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '600a9f2c553b276dfdf9c154fdef00f767460a23' => 
    array (
      0 => '/var/www/cgi-bin/demo/src/application/sample/view/auth/login.tpl',
      1 => 1423459755,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21025855354cee31ef21144-43201344',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_54cee31f020e89_42167025',
  'variables' => 
  array (
    'GlobalScreenHolder' => 0,
    'this' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54cee31f020e89_42167025')) {function content_54cee31f020e89_42167025($_smarty_tpl) {?><html>
<head>
    <content-type="text/html charset='UTF-8'">
    <title>Sampleフォーム ログイン</title>
</head>
<body>
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['GlobalScreenHolder']->value->header, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <h1>Sampleフォーム ログイン</h1>
<?php if ($_smarty_tpl->tpl_vars['this']->value->errors()->has("auth")) {?>
    <font color="red"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['this']->value->errors()->show("auth"), ENT_QUOTES, 'UTF-8', true);?>
</font>
<?php }?>
    <form action="/demo/sample/auth/authenticate" method="POST">
        <dl>
            <dd>ID</dd>
            <dd><input type="text" name="login_id" value=""></dd>
            <dd>&nbsp;</dd>
            <dd>パスワード</dd>
            <dd><input type="password" name="login_pw" value=""></dd>
            <dd>&nbsp;</dd>
            <dd><input type="submit" value="　ログイン　"></dd>
        </dl>
    </form>
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['GlobalScreenHolder']->value->footer, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
<?php }} ?>
