<?php /* Smarty version Smarty-3.1.21, created on 2014-12-15 16:19:47
         compiled from "/var/www/cgi-bin/demo,zend/src/demo/view/error/404.phtml" */ ?>
<?php /*%%SmartyHeaderCode:2085816367548e8b93943981-00193935%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '822b80502fba0f07d105d3e333db54de9cd7113e' => 
    array (
      0 => '/var/www/cgi-bin/demo,zend/src/demo/view/error/404.phtml',
      1 => 1417157194,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2085816367548e8b93943981-00193935',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_548e8b939acb08_54067535',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e8b939acb08_54067535')) {function content_548e8b939acb08_54067535($_smarty_tpl) {?><h1><?php echo '<?php'; ?>
 echo $this->translate('A 404 error occurred') <?php echo '?>'; ?>
</h1>
<h2><?php echo '<?php'; ?>
 echo $this->message <?php echo '?>'; ?>
hogehoghoe</h2>

<?php echo '<?php'; ?>
 if (isset($this->reason) && $this->reason): <?php echo '?>'; ?>


<?php echo '<?php'; ?>

$reasonMessage= '';
switch ($this->reason) {
    case 'error-controller-cannot-dispatch':
        $reasonMessage = $this->translate('The requested controller was unable to dispatch the request.');
        break;
    case 'error-controller-not-found':
        $reasonMessage = $this->translate('The requested controller could not be mapped to an existing controller class.');
        break;
    case 'error-controller-invalid':
        $reasonMessage = $this->translate('The requested controller was not dispatchable.');
        break;
    case 'error-router-no-match':
        $reasonMessage = $this->translate('The requested URL could not be matched by routing.');
        break;
    default:
        $reasonMessage = $this->translate('We cannot determine at this time why a 404 was generated.');
        break;
}
<?php echo '?>'; ?>


<p><?php echo '<?php'; ?>
 echo $reasonMessage <?php echo '?>'; ?>
</p>

<?php echo '<?php'; ?>
 endif <?php echo '?>'; ?>


<?php echo '<?php'; ?>
 if (isset($this->controller) && $this->controller): <?php echo '?>'; ?>


<dl>
    <dt><?php echo '<?php'; ?>
 echo $this->translate('Controller') <?php echo '?>'; ?>
:</dt>
    <dd><?php echo '<?php'; ?>
 echo $this->escapeHtml($this->controller) <?php echo '?>'; ?>

<?php echo '<?php'; ?>

if (isset($this->controller_class)
    && $this->controller_class
    && $this->controller_class != $this->controller
) {
    echo '(' . sprintf($this->translate('resolves to %s'), $this->escapeHtml($this->controller_class)) . ')';
}
<?php echo '?>'; ?>

</dd>
</dl>

<?php echo '<?php'; ?>
 endif <?php echo '?>'; ?>


<?php echo '<?php'; ?>
 if (isset($this->display_exceptions) && $this->display_exceptions): <?php echo '?>'; ?>


<?php echo '<?php'; ?>
 if(isset($this->exception) && $this->exception instanceof Exception): <?php echo '?>'; ?>

<hr/>
<h2><?php echo '<?php'; ?>
 echo $this->translate('Additional information') <?php echo '?>'; ?>
:</h2>
<h3><?php echo '<?php'; ?>
 echo get_class($this->exception); <?php echo '?>'; ?>
</h3>
<dl>
    <dt><?php echo '<?php'; ?>
 echo $this->translate('File') <?php echo '?>'; ?>
:</dt>
    <dd>
        <pre class="prettyprint linenums"><?php echo '<?php'; ?>
 echo $this->exception->getFile() <?php echo '?>'; ?>
:<?php echo '<?php'; ?>
 echo $this->exception->getLine() <?php echo '?>'; ?>
</pre>
    </dd>
    <dt><?php echo '<?php'; ?>
 echo $this->translate('Message') <?php echo '?>'; ?>
:</dt>
    <dd>
        <pre class="prettyprint linenums"><?php echo '<?php'; ?>
 echo $this->exception->getMessage() <?php echo '?>'; ?>
</pre>
    </dd>
    <dt><?php echo '<?php'; ?>
 echo $this->translate('Stack trace') <?php echo '?>'; ?>
:</dt>
    <dd>
        <pre class="prettyprint linenums"><?php echo '<?php'; ?>
 echo $this->exception->getTraceAsString() <?php echo '?>'; ?>
</pre>
    </dd>
</dl>
<?php echo '<?php'; ?>

    $e = $this->exception->getPrevious();
    if ($e) :
<?php echo '?>'; ?>

<hr/>
<h2><?php echo '<?php'; ?>
 echo $this->translate('Previous exceptions') <?php echo '?>'; ?>
:</h2>
<ul class="unstyled">
    <?php echo '<?php'; ?>
 while($e) : <?php echo '?>'; ?>

    <li>
        <h3><?php echo '<?php'; ?>
 echo get_class($e); <?php echo '?>'; ?>
</h3>
        <dl>
            <dt><?php echo '<?php'; ?>
 echo $this->translate('File') <?php echo '?>'; ?>
:</dt>
            <dd>
                <pre class="prettyprint linenums"><?php echo '<?php'; ?>
 echo $e->getFile() <?php echo '?>'; ?>
:<?php echo '<?php'; ?>
 echo $e->getLine() <?php echo '?>'; ?>
</pre>
            </dd>
            <dt><?php echo '<?php'; ?>
 echo $this->translate('Message') <?php echo '?>'; ?>
:</dt>
            <dd>
                <pre class="prettyprint linenums"><?php echo '<?php'; ?>
 echo $e->getMessage() <?php echo '?>'; ?>
</pre>
            </dd>
            <dt><?php echo '<?php'; ?>
 echo $this->translate('Stack trace') <?php echo '?>'; ?>
:</dt>
            <dd>
                <pre class="prettyprint linenums"><?php echo '<?php'; ?>
 echo $e->getTraceAsString() <?php echo '?>'; ?>
</pre>
            </dd>
        </dl>
    </li>
    <?php echo '<?php'; ?>

        $e = $e->getPrevious();
        endwhile;
    <?php echo '?>'; ?>

</ul>
<?php echo '<?php'; ?>
 endif; <?php echo '?>'; ?>


<?php echo '<?php'; ?>
 else: <?php echo '?>'; ?>


<h3><?php echo '<?php'; ?>
 echo $this->translate('No Exception available') <?php echo '?>'; ?>
</h3>

<?php echo '<?php'; ?>
 endif <?php echo '?>'; ?>


<?php echo '<?php'; ?>
 endif <?php echo '?>'; ?>

<?php }} ?>
