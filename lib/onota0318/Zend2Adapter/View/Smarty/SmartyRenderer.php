<?php
/**
 * @buief Smarty用のRenderer
 * @details Smarty用のRenderer
 * ZSmartyがクソ過ぎるのでソースを基に改修
 * 
 * @package Onota0318
 * @since 2014.12
 */
namespace Onota0318\Zend2Adapter\View\Smarty;

use Zend\View\Renderer\PhpRenderer;
use Zend\View\Model\ViewModel;

class SmartyRenderer extends PhpRenderer
{
    /**
     * Smarty object
     * @var Smarty
     */
    protected $smarty;
    
    /**
     * Constructor
     *
     * @param string $tmplPath
     * @param array $config
     * @return void
     */
    public function __construct($tmplPath = null, $config = array())
    {
        $this->smarty = new \Smarty();

        if (null !== $tmplPath) {
            $this->setScriptPath($tmplPath);
        }

        foreach ($config as $key => $value) {
            $this->smarty->$key = $value;
        }
        
        //必須
        $this->smarty->default_modifiers = array('escape:html');
        $this->smarty->error_reporting   = 'E_ALL & ~E_NOTICE';
    }

    /**
     * Return the template engine object
     *
     * @return Smarty
     */
    public function getEngine()
    {
        return $this->smarty;
    }

    /**
     * Set the path to the templates
     *
     * @param string $path The directory to set as the path.
     * @return void
     */
    public function setScriptPath($path)
    {
        if (is_readable($path)) {
            $this->smarty->template_dir = $path;
            return;
        }

        throw new \Exception('Invalid path provided');
    }

    /**
     * Retrieve the current template directory
     *
     * @return string
     */
    public function getScriptPaths()
    {
        return array($this->smarty->template_dir);
    }

    /**
     * Assign a variable to the template
     *
     * @param string $key The variable name.
     * @param mixed $val The variable value.
     * @return void
     */
    public function __set($key, $val)
    {
        $this->smarty->assign($key, $val);
    }

    /**
     * Allows testing with empty() and isset() to work
     *
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        return null !== $this->smarty->getTemplateVars($key);
    }
    
    public function __get($key)
    {
        return $this->smarty->getTemplateVars($key);
    }

    /**
     * Allows unset() on object properties to work
     *
     * @param string $key
     * @return void
     */
    public function __unset($key)
    {
        $this->smarty->clear_assign($key);
    }

    /**
     * Assign variables to the template
     *
     * Allows setting a specific key to the specified value, OR passing
     * an array of key => value pairs to set en masse.
     *
     * @see __set()
     * @param string|array $spec The assignment strategy to use (key or
     * array of key => value pairs)
     * @param mixed $value (Optional) If assigning a named variable,
     * use this as the value.
     * @return void
     */
    public function assign($spec, $value = null)
    {
        if (is_array($spec)) {
            $this->smarty->assign($spec);
            return;
        }

        $this->smarty->assign($spec, $value);
    }

    /**
     * Clear all assigned variables
     *
     * Clears all variables assigned to Zend_View either via
     * {@link assign()} or property overloading
     * ({@link __get()}/{@link __set()}).
     *
     * @return void
     */
    public function clearVars()
    {
        $this->smarty->clear_all_assign();
    }

    /**
     * Processes a template and returns the output.
     *
     * @param string $name The template to process.
     * @return string The output.
     */
    public function render($name, $vars = null)
    {
        //ViewHelperを呼べるように
        $this->assign("this", $this);

        if ($name instanceof ViewModel) {
            $model = $name;
            $name = $model->getTemplate();
            if (empty($name)) {
                throw new Exception\DomainException(sprintf(
                    '%s: received View Model argument, but template is empty',
                    __METHOD__
                ));
            }

            // Give view model awareness via ViewModel helper
            $helper = $this->plugin('view_model');
            $helper->setCurrent($model);

            foreach($model->getVariables() as $key => $value) {
                $this->assign($key, $value);
            }

            unset($model);
            
            $this->file = $this->resolver($name);
           
            $content = $this->smarty->fetch($this->file);
            return $this->getFilterChain()->filter($this->smarty->fetch($this->file));
        }
        
        else {
            if (null !== $vars) {
                foreach ($vars as $k => $v) {
                    $this->assign($k, $v);
                }
            }
            
            $this->file = $this->resolver($name);
            $this->this = $this;

            return $this->getFilterChain()->filter($this->smarty->fetch($this->file));
        }
    }
}
