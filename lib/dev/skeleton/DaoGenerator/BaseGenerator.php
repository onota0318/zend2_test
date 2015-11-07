<?php

abstract class BaseGenerator
{
    const ENCLOSURE_START = "<%";
    const ENCLOSURE_END   = "%>";
    const INDENT = "    ";
    const CRLF   = "\n";
    const EXTENSION = ".php";

    protected $pdo = null;
    protected $schemas = array();
    protected $table = "";
    protected $template = "";
    protected $output = "";
    protected $namespace = "";

    public function __construct(PDO $pdo, array $schemas, $table, $template_dir, $output, $namespace)
    {
        $this->pdo       = $pdo;
        $this->schemas   = $schemas;
        $this->table     = $table;
        $this->template  = $template_dir . static::TEMPLATE_FILE_NAME;
        $this->output    = $output;
        $this->namespace = $namespace;
    }

    abstract public function generate();

    /**
     *
     */
    protected function indents($count)
    {
        return str_repeat(self::INDENT, $count);
    }

    protected function convertSnakeToCamel($target)
    {
        if (false === strpos($target, "_")) {
            return strtolower($target);
        }

        $tmp = explode("_", strtolower($target));
        $res = $tmp[0];
        
        foreach (array_slice($tmp, 1) as $word) {
            $res .= ucfirst($word);
        }

        return $res;
    }

    protected function convertSnakeToPascal($target)
    {
        if (false === strpos($target, "_")) {
            return ucfirst(strtolower($target));
        }

        $tmp = explode("_", strtolower($target));
        $res = ucfirst($tmp[0]);
        
        foreach (array_slice($tmp, 1) as $word) {
            $res .= ucfirst($word);
        }

        return $res;
    }
}

