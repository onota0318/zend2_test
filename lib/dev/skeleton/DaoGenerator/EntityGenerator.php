<?php

class EntityGenerator extends BaseGenerator
{
    const TEMPLATE_FILE_NAME = "entity.txt";

    private $_replaced = array(
        "TABLE"        => "",
        "DATE"         => "",
        "NAMESPACE"    => "", 
        "FIELDS"       => "",
    );

    private $_convertDataTypes = array(
        "datetime"   => "datetime",
        "date"       => "date",
        "tinyint(1)" => "boolean",
    );

    public function generate()
    {
        $fields = $this->_generateFields($this->schemas);

        $this->_disposeTable($this->table);
        $this->_disposeDate(date("Y/m/d"));
        $this->_disposeNamespace($this->namespace);
        $this->_disposeFields($fields);

        $data = $this->_replaceTemplate();
        $this->_outputFile($this->output, $data);
    }


    private function _generateFields(array $fields)
    {
        $hasUnderScore = function ($target) {
            return false !== strpos($target, "_");
        };

        $res = array();
        foreach ($fields as $field) {

            $data = "";

            $isAppendColumn = false;
            $isAppendCastTo = false;

            $property = strtolower($field["COLUMN_NAME"]);
            $name     = $property;
            $type     = $field["COLUMN_TYPE"];

            if ($hasUnderScore($name)) {
                $isAppendColumn = true;
                $property = $this->convertSnakeToCamel($name);
            }

            if (isset($this->_convertDataTypes[$type])) {
                $isAppendCastTo = true;
                $type = $this->_convertDataTypes[$type];
            }

            $nullable = "";
            if ($field["IS_NULLABLE"] === "NO") {
                $nullable = "not null";
            }

            $data = $this->indents(1) . '/**' . parent::CRLF
                  . $this->indents(1) . ' * @var ' . $field["COLUMN_TYPE"] . ' ' . $nullable . parent::CRLF;

            if (strlen($field["COLUMN_DEFAULT"]) > 0) {
                $data .= $this->indents(1) . ' * @default ' . $field["COLUMN_DEFAULT"] . parent::CRLF;
            }

            if ($isAppendColumn) {
                $data .= $this->indents(1) . ' * @column ' . $name . parent::CRLF;
            }
            
            if ($isAppendCastTo) {
                $data .= $this->indents(1) . ' * @castTo ' . $type . parent::CRLF;
            }

            $data .= $this->indents(1) . ' */' . parent::CRLF;

            $data .= $this->indents(1) . 'protected $' . $property . ';';
            $res[] = $data;
            $res[] = ""/*dummy*/;
        }

        return $res;
    }
    

    private function _disposeTable($data)
    {
        $this->_replaced["TABLE"] = $this->convertSnakeToPascal($data);
    }

    private function _disposeDate($data)
    {
        $this->_replaced["DATE"] = $data;
    }

    private function _disposeNamespace($data)
    {
        $this->_replaced["NAMESPACE"] = $data;
    }

    private function _disposeFields($data)
    {
        $this->_replaced["FIELDS"] = implode(parent::CRLF, $data);
    }

    private function _replaceTemplate()
    {
        $data = file_get_contents($this->template);

        foreach ($this->_replaced as $key => $value) {
            $target = parent::ENCLOSURE_START . $key . parent::ENCLOSURE_END;
            $data = str_replace($target , $value, $data);
        }

        return $data;
    }

    
    private function _outputFile($output, $data)
    {
        $filename = $output . DS . $this->_replaced["TABLE"] . "Entity" . parent::EXTENSION;
        file_put_contents($filename, $data);
    }
}

