<?php

class ValidateGenerator extends BaseGenerator
{
    const TEMPLATE_FILE_NAME = "validator.txt";

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
        $res = array();
        foreach ($fields as $field) {
            
            $data  = $this->indents(1) . '/**' . parent::CRLF
                   . $this->indents(1) . ' * validate for ' . $field["COLUMN_NAME"] . ' ' . parent::CRLF
                   . $this->indents(1) . ' * ' . parent::CRLF
                   . $this->indents(1) . ' * @param mixed $input target value.' . parent::CRLF
                   . $this->indents(1) . ' * @param array $messages message list.' . parent::CRLF
                   . $this->indents(1) . ' * @return void' . parent::CRLF
                   . $this->indents(1) . ' */' . parent::CRLF;


            $data .= $this->indents(1) . 'public function validate' . $this->convertSnakeToPascal($field["COLUMN_NAME"]) . '($input, array $messages = array())' . parent::CRLF
                  .  $this->indents(1) . '{' . parent::CRLF
                  .  $this->_generateMethod($field)
                  .  $this->indents(1) . '}' . parent::CRLF;

            $res[] = $data;
        }

        return $res;
    }
    

    private function _generateMethod(array $field)
    {
        $type = "";

        if (preg_match("/(int|float|double)/ui", $field["DATA_TYPE"])) {
            $type = "Int";
        }
        elseif (preg_match("/(char|text|blob|binary)/ui", $field["DATA_TYPE"])) {
            $type = "Text";
        }
        elseif (preg_match("/(date|time|year)/ui", $field["DATA_TYPE"])) {
            $type = "DateTime";
        }
        else {
            throw new Exception("unknown data type.[".$field["DATA_TYPE"]."]");
        }

        $method = "_generate" . $type . "Type";
        return $this->$method($field, $field["IS_NULLABLE"] !== "NO");
    }



    private function _generateIntType(array $field, $nullable)
    {
        $notEmpty = "";
        if (!$nullable) {
            $notEmpty = $this->indents(4) . '$this->getNotEmptySignature($messages),' . parent::CRLF;
        }

        $data = $this->indents(2) . '$logical  = "'.$field["COLUMN_COMMENT"].'";'. parent::CRLF
              . $this->indents(2) . '$field    = "'.$field["COLUMN_NAME"].'";' . parent::CRLF
              . $this->indents(2) . '$nullable = '.var_export($nullable, true).';' . parent::CRLF
              . parent::CRLF
              . $this->indents(2) . '$validator = array(' . parent::CRLF
              . $this->indents(3) .     '"name"       => $field,' . parent::CRLF
              . $this->indents(3) .     '"required"   => true,'   . parent::CRLF
              . $this->indents(3) .     '"validators" => array('  . parent::CRLF
              . $notEmpty
              . $this->indents(4) .          '$this->getDigitsSignature($messages),' . parent::CRLF
              . $this->indents(3) .     '),' . parent::CRLF
              . $this->indents(2) . ');' . parent::CRLF
              . parent::CRLF
              . $this->indents(2) . '$this->verify($field, $input, $validator, $nullable, array($logical));' . parent::CRLF;

        return $data;
    }



    private function _generateTextType(array $field, $nullable)
    {
        $notEmpty = "";
        if (!$nullable) {
            $notEmpty = $this->indents(4) . '$this->getNotEmptySignature($messages),' . parent::CRLF;
        }

        $data = $this->indents(2) . '$logical  = "'.$field["COLUMN_COMMENT"].'";'. parent::CRLF
              . $this->indents(2) . '$field     = "'.$field["COLUMN_NAME"].'";' . parent::CRLF
              . $this->indents(2) . '$nullable  = '.var_export($nullable, true).';' . parent::CRLF
              . $this->indents(2) . '$minLength = 0;' . parent::CRLF
              . $this->indents(2) . '$maxLength = '.$field["CHARACTER_MAXIMUM_LENGTH"].';' . parent::CRLF
              . parent::CRLF
              . $this->indents(2) . '$validator = array(' . parent::CRLF
              . $this->indents(3) .     '"name"       => $field,' . parent::CRLF
              . $this->indents(3) .     '"required"   => true,'   . parent::CRLF
              . $this->indents(3) .     '"validators" => array('  . parent::CRLF
              . $notEmpty
              . $this->indents(4) .          '$this->getStringLengthSignature($minLength, $maxLength, $messages),' . parent::CRLF
              . $this->indents(4) .          '$this->getUnsupportedStringSignature($messages),' . parent::CRLF
              . $this->indents(3) .     '),' . parent::CRLF
              . $this->indents(2) . ');' . parent::CRLF
              . parent::CRLF
              . $this->indents(2) . '$this->verify($field, $input, $validator, $nullable, array($logical, $minLength, $maxLength));' . parent::CRLF;

        return $data;

    }

    private function _generateDateTimeType(array $field, $nullable)
    {

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
        $filename = $output . DS . $this->_replaced["TABLE"] . "Validator" . parent::EXTENSION;
        file_put_contents($filename, $data);
    }
}

