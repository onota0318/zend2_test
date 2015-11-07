<?php /* Smarty version Smarty-3.1.21, created on 2015-02-12 16:31:40
         compiled from "/var/www/cgi-bin/demo/src/application/sample/view/form/input.tpl" */ ?>
<?php /*%%SmartyHeaderCode:176960994054d86ec4c6c410-27273882%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24956af4d7d5ef486a28db39f050dfb77b1ff535' => 
    array (
      0 => '/var/www/cgi-bin/demo/src/application/sample/view/form/input.tpl',
      1 => 1423726297,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '176960994054d86ec4c6c410-27273882',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_54d86ec4dc3de1_65265626',
  'variables' => 
  array (
    'GlobalScreenHolder' => 0,
    'this' => 0,
    'SampleFormScreenHolder' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54d86ec4dc3de1_65265626')) {function content_54d86ec4dc3de1_65265626($_smarty_tpl) {?><html>
<head>
    <content-type="text/html charset='UTF-8'">
    <title>Sampleフォーム 入力画面</title>
</head>
<body>
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['GlobalScreenHolder']->value->header, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <h1>Sampleフォーム 入力画面</h1>

    <?php if ($_smarty_tpl->tpl_vars['this']->value->errors()->exists()) {?>
    <div style="color:red;">
        <p>※エラー※</p>
        <?php if ($_smarty_tpl->tpl_vars['this']->value->errors()->has('first_name')) {?>
            <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['this']->value->errors()->show('first_name'), ENT_QUOTES, 'UTF-8', true);?>
</p>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['this']->value->errors()->has('last_name')) {?>
            <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['this']->value->errors()->show('last_name'), ENT_QUOTES, 'UTF-8', true);?>
</p>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['this']->value->errors()->has('gender')) {?>
            <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['this']->value->errors()->show('gender'), ENT_QUOTES, 'UTF-8', true);?>
</p>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['this']->value->errors()->has('pref')) {?>
            <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['this']->value->errors()->show('pref'), ENT_QUOTES, 'UTF-8', true);?>
</p>
        <?php }?>
    </div>
    <?php }?>

    <form action="/demo/sample/form/confirm" method="POST">
        <dl>
            <dd>苗字</dd>
            <dd><input type="text" name="first_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->first_name, ENT_QUOTES, 'UTF-8', true);?>
"></dd>
            <dd>&nbsp;</dd>
            <dd>名前</dd>
            <dd><input type="text" name="last_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->last_name, ENT_QUOTES, 'UTF-8', true);?>
"></dd>
            <dd>&nbsp;</dd>
            <dd>性別</dd>
            <dd><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->gender_list; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <input type="radio" name="gender" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['k']->value==$_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->gender) {?> checked <?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8', true);?>
 
                <?php } ?>
            </dd>
            <dd>&nbsp;</dd>
            <dd>都道府県</dd>
            <dd>
                <select name="pref">
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->pref_list; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['k']->value==$_smarty_tpl->tpl_vars['SampleFormScreenHolder']->value->pref) {?> selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                    <?php } ?>
                </select>
            </dd>
            <dd>&nbsp;</dd>
            <dd><input type="submit" value="　送信　"></dd>
        </dl>
    </form>
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['GlobalScreenHolder']->value->footer, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
<?php }} ?>
