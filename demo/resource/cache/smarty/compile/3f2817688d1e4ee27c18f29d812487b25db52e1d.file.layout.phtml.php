<?php /* Smarty version Smarty-3.1.21, created on 2014-12-15 16:19:43
         compiled from "/var/www/cgi-bin/demo,zend/src/demo/view/layout/layout.phtml" */ ?>
<?php /*%%SmartyHeaderCode:1519845829548e8b8f8518d1-40027352%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f2817688d1e4ee27c18f29d812487b25db52e1d' => 
    array (
      0 => '/var/www/cgi-bin/demo,zend/src/demo/view/layout/layout.phtml',
      1 => 1415684594,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1519845829548e8b8f8518d1-40027352',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_548e8b8f8bac72_27673454',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e8b8f8bac72_27673454')) {function content_548e8b8f8bac72_27673454($_smarty_tpl) {?><?php echo '<?php'; ?>
 echo $this->doctype(); <?php echo '?>'; ?>


<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php echo '<?php'; ?>
 echo $this->headTitle('ZF2 '. $this->translate('Skeleton Application'))->setSeparator(' - ')->setAutoEscape(false) <?php echo '?>'; ?>


        <?php echo '<?php'; ?>
 echo $this->headMeta()
            ->appendName('viewport', 'width=device-width, initial-scale=1.0')
            ->appendHttpEquiv('X-UA-Compatible', 'IE=edge')
        <?php echo '?>'; ?>


        <!-- Le styles -->
        <?php echo '<?php'; ?>
 echo $this->headLink(array('rel' => 'shortcut icon', 'type' => 'image/vnd.microsoft.icon', 'href' => $this->basePath() . '/img/favicon.ico'))
                        ->prependStylesheet($this->basePath() . '/css/style.css')
                        ->prependStylesheet($this->basePath() . '/css/bootstrap-theme.min.css')
                        ->prependStylesheet($this->basePath() . '/css/bootstrap.min.css') <?php echo '?>'; ?>


        <!-- Scripts -->
        <?php echo '<?php'; ?>
 echo $this->headScript()
            ->prependFile($this->basePath() . '/js/bootstrap.min.js')
            ->prependFile($this->basePath() . '/js/jquery.min.js')
            ->prependFile($this->basePath() . '/js/respond.min.js', 'text/javascript', array('conditional' => 'lt IE 9',))
            ->prependFile($this->basePath() . '/js/html5shiv.js',   'text/javascript', array('conditional' => 'lt IE 9',))
        ; <?php echo '?>'; ?>


    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo '<?php'; ?>
 echo $this->url('home') <?php echo '?>'; ?>
"><img src="<?php echo '<?php'; ?>
 echo $this->basePath('img/zf2-logo.png') <?php echo '?>'; ?>
" alt="Zend Framework 2"/>&nbsp;<?php echo '<?php'; ?>
 echo $this->translate('Skeleton Application') <?php echo '?>'; ?>
</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?php echo '<?php'; ?>
 echo $this->url('home') <?php echo '?>'; ?>
"><?php echo '<?php'; ?>
 echo $this->translate('Home') <?php echo '?>'; ?>
</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container">
            <?php echo '<?php'; ?>
 echo $this->content; <?php echo '?>'; ?>

            <hr>
            <footer>
                <p>&copy; 2005 - <?php echo '<?php'; ?>
 echo date('Y') <?php echo '?>'; ?>
 by Zend Technologies Ltd. <?php echo '<?php'; ?>
 echo $this->translate('All rights reserved.') <?php echo '?>'; ?>
</p>
            </footer>
        </div> <!-- /container -->
        <?php echo '<?php'; ?>
 echo $this->inlineScript() <?php echo '?>'; ?>

    </body>
</html>
<?php }} ?>
