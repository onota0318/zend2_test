<?php

class TableGenerator extends BaseGenerator
{
    const TEMPLATE_FILE_NAME = "table.txt";

    private $_replaced = array(
        "TABLE"        => "",
        "DATE"         => "",
        "NAMESPACE"    => "", 
        "REALNAME"     => "",
    );


    public function generate()
    {
        $this->_disposeTable($this->table);
        $this->_disposeDate(date("Y/m/d"));
        $this->_disposeNamespace($this->namespace);
        $this->_disposeRealName($this->table);

        $data = $this->_replaceTemplate();
        $this->_outputFile($this->output, $data);
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

    private function _disposeRealName($data)
    {
        $this->_replaced["REALNAME"] = $data;
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
        $filename = $output . DS . $this->_replaced["TABLE"] . "Table" . parent::EXTENSION;
        file_put_contents($filename, $data);
    }
}

