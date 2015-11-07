<?php
define("DS", DIRECTORY_SEPARATOR);

require_once 'BaseGenerator.php';
require_once 'EntityGenerator.php';
require_once 'TableGenerator.php';
require_once 'ValidateGenerator.php';


class DaoGenerator
{
    private $_host = "localhost";
    private $_name = "";
    private $_user = "";
    private $_pass = "";
    private $_output    = "";
    private $_namespace = "";

    private $_templateDir = "";

    private $_pdo  = null;

    /**
     *
     */
    public function __construct(array $argv = array())
    {
        if ($argv[1] === "--help"
                || count($argv) <= 2) {

            self::showUsage();
            exit(0);
        }

        $this->_initializeArgs(array_slice($argv, 1));
        $this->_templateDir = dirname(__FILE__) . DS . "template" . DS;
    }

    /**
     *
     */
    private function _initializeArgs(array $argv)
    {
        foreach ($argv as $arg) {
            
            if (strlen($arg) <= 0) {
                continue;
            }

            list($key, $value) = explode("=", $arg);

            switch ($key) {
                case "-h":
                    $this->_host = $value;
                    break;

                case "-u":
                    $this->_user = $value;
                    break;

                case "-db":
                case "-name":
                    $this->_name = $value;
                    break;

                case "-p":
                case "-pass":
                    $this->_pass = $value;
                    break;

                case "-output":
                    $this->_output = $value;
                    break;

                case "-namespace":
                    $this->_namespace = $value;
                    break;
            }
        }
    }

    /**
     *
     */
    public function generate()
    {
        try {
            $this->_connect();

            $tables = $this->_getTableList();

            $this->_generate($tables);

        }
        catch (Exception $e) {
            $message = "[Error.] : " . $e->getMessage();
            echo $message . "\n\n";
            self::showUsage();
            exit(1);
        }
    }

    /**
     * @throws PDOException
     */
    private function _connect()
    {
        $dsn = "mysql:"
             . "dbname=".$this->_name.";"
             . "host=".$this->_host.";"
             . "port=3306";
        
        $this->_pdo = new PDO($dsn, $this->_user, $this->_pass);
        $this->_pdo->query("set names utf8");
    }
    

    /**
     *
     */
    private function _getTableList()
    {
        $sql = "show tables";
        $handle = $this->_pdo->query($sql);

        $res = array();
        foreach ($handle as $row) {
            $res[] = $row[0];
        }

        return $res;
    }


    /**
     *
     */
    private function _generate(array $tables)
    {
        foreach ($tables as $table) {

            $schemas = $this->_getInfomationSchema($table);

            echo "Generating:::$table\n\n";
            $this->_generateEntity($schemas, $table);
            $this->_generateTable($schemas, $table);
            $this->_generateValidator($schemas, $table);
        }
    }

    /**
     *
     */
    private function _getInfomationSchema($table)
    {
        $stmt = $this->_pdo->prepare(
           "select "
         .    "* "
         . "from "
         .    "information_schema.columns "
         . "where "
         .    "table_name = :table"
//         , array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
        );

        $stmt->execute(array(":table" => $table));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    private function _generateEntity(array $schemas, $table)
    {
        (new EntityGenerator(
             $this->_pdo
            ,$schemas
            ,$table
            ,$this->_templateDir
            ,$this->_output
            ,$this->_namespace
        ))->generate();
    }

    private function _generateTable(array $schemas, $table)
    {
        (new TableGenerator(
             $this->_pdo
            ,$schemas
            ,$table
            ,$this->_templateDir
            ,$this->_output
            ,$this->_namespace
        ))->generate();
    }

    private function _generateValidator(array $schemas, $table)
    {
        (new ValidateGenerator(
             $this->_pdo
            ,$schemas
            ,$table
            ,$this->_templateDir
            ,$this->_output
            ,$this->_namespace
        ))->generate();
    }

    /**
     *
     */
    public static function showUsage()
    {
        $usage = "How To Use::\n\n".
        "execute）/path/to/php /path/to/bin/dao_generator [args]\n".
        "args）\n\n".
        "        -h：input your database host. ex) -h=localhost\n\n".
        "        -u：input your database user. ex) -u=hogeuser\n\n".
        "        -db：input your database name. ex) -db=demo\n\n".
        "        -p：input your database password. ex) -p=pass\n\n".
        "        -output：output generated class file. ex) -output=/path/to/\n\n".
        "        -namespace：namespace of generated class. ex) -namespace=Hoge\\Model\n\n"
        ;
        echo $usage;
    }

}

$generator = new DaoGenerator($_SERVER["argv"]);
$generator->generate();
