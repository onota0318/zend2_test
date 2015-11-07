<?php /* Smarty version Smarty-3.1.21, created on 2015-02-02 10:36:35
         compiled from "/var/www/cgi-bin/demo/src/application/sample/view/index/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:164157301154bf3bca556116-44794227%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a8ffd774ea9598ccad683b4a151f0034c4827518' => 
    array (
      0 => '/var/www/cgi-bin/demo/src/application/sample/view/index/index.tpl',
      1 => 1422840993,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '164157301154bf3bca556116-44794227',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_54bf3bca740f91_52828773',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54bf3bca740f91_52828773')) {function content_54bf3bca740f91_52828773($_smarty_tpl) {?><html>
<head>
    <content-type="text/html charset='UTF-8'">
    <title>Sampleフォーム</title>
</head>
<body>
    <h1>Sampleフォーム 入力画面</h1>
    <form action="" method="POST">
        <dl>
            <dd>苗字</dd>
            <dd><input type="text" name="first_name" value=""></dd>
            <dd>&nbsp;</dd>
            <dd>名前</dd>
            <dd><input type="text" name="last_name" value=""></dd>
            <dd>&nbsp;</dd>
            <dd>性別</dd>
            <dd><input type="radio" name="sex" value="1">男性
                <input type="radio" name="sex" value="2">女性</dd>
            <dd>&nbsp;</dd>
            <dd><input type="submit" value="　送信　"></dd>
        </dl>
    </form>
</body>
<?php }} ?>
