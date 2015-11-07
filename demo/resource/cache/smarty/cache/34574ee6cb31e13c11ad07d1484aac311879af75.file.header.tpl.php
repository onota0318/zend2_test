<?php /* Smarty version Smarty-3.1.21, created on 2015-02-12 15:35:34
         compiled from "/var/www/cgi-bin/demo/src/application/sample/view/layout/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:111579795254d19059da6609-76497436%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '34574ee6cb31e13c11ad07d1484aac311879af75' => 
    array (
      0 => '/var/www/cgi-bin/demo/src/application/sample/view/layout/header.tpl',
      1 => 1423722922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '111579795254d19059da6609-76497436',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_54d19059ed1f00_08668219',
  'variables' => 
  array (
    'GlobalScreenHolder' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54d19059ed1f00_08668219')) {function content_54d19059ed1f00_08668219($_smarty_tpl) {?><div>
    ヘッダだよー
    <?php if ($_smarty_tpl->tpl_vars['GlobalScreenHolder']->value->isLogin==true) {?>
    <dl>
        <dd>
            ようこそ <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['GlobalScreenHolder']->value->identity->login_id, ENT_QUOTES, 'UTF-8', true);?>
 さん 
            <a href="/demo/sample/auth/logout">ログアウト</a>
        </dd>
    </dl>
    <?php }?>
</div>
<?php }} ?>
