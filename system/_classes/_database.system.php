<?php
/**
 * @package   WarpKnot
 */

class DB
{
    # @object, The PDO object

    public $bConnected = false;

    # @object, PDO statement object
    public $pdoDebug;

    # @bool ,  Connected to the database
    private $pdo;

    # @array, The parameters of the SQL query
    private $sQuery;

    # @array, PDO DEBUG
    private $parameters;

    /**
     *  Default Constructor
     *
     *   1. Connect to database.
     *   2. Creates the parameter array.
     *
     * @param $_DB_CONNECT
     */
    public function __construct($_DB_CONNECT)
    {
        $this->Connect($_DB_CONNECT);
        $this->parameters = array();
    }

    /**
     *  This method makes connection to the database.
     *
     *  1. Reads the database settings from an object.
     *  2. Tries to connect to the database.
     *
     * @param $_DB_CONNECT
     */
    private function Connect($_DB_CONNECT)
    {
        /**
         * Debug mode : true | false
         */
        global $_DEBUG;

        $_DB_CONNECT["_DB_PORT"]                = isset($_DB_CONNECT["_DB_PORT"]) ? empty($_DB_CONNECT["_DB_PORT"]) ? '' : ';port=' . $_DB_CONNECT["_DB_PORT"] : '';
        $_DB_CONNECT["_DB_DATABASE"]            = isset($_DB_CONNECT["_DB_DATABASE"]) ? empty($_DB_CONNECT["_DB_DATABASE"]) ? '' : ';dbname=' . $_DB_CONNECT["_DB_DATABASE"] : '';
        $_DB_CONNECT["_DB_CHARSET"]             = isset($_DB_CONNECT["_DB_CHARSET"]) ? empty($_DB_CONNECT["_DB_CHARSET"]) ? '' : ';charset=' . $_DB_CONNECT["_DB_CHARSET"] : '';
        $_DB_CONNECT["_DB_EXTERNAL_CONNECTION"] = isset($_DB_CONNECT["_DB_EXTERNAL_CONNECTION"]) ? $_DB_CONNECT["_DB_EXTERNAL_CONNECTION"] ? true : false : false;

        $dsn = 'mysql:' . 'host=' . $_DB_CONNECT["_DB_HOSTNAME"] . $_DB_CONNECT["_DB_PORT"] . $_DB_CONNECT["_DB_DATABASE"] . $_DB_CONNECT["_DB_CHARSET"];

        try {
            # Read settings from the object, set UTF8
            $this->pdo = new PDO($dsn, $_DB_CONNECT["_DB_USERNAME"], $_DB_CONNECT["_DB_PASSWORD"]);

            //utf8
            # We can now log any exceptions on Fatal error.
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            # Disable emulation of prepared statements, use REAL prepared statements instead.
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            # Connection succeeded, set the boolean to true.
            $this->bConnected = true;
        } catch (PDOException $e) {
            if ($_DEBUG):
                die(json_encode(["code" => "2", "message" => $e->getMessage()]));
            else:
                if ($_DB_CONNECT["_DB_EXTERNAL_CONNECTION"]) {
                    $this->bConnected = false;
                } else {
                    die(json_encode(["code" => "2", "message" => "Internal system error"]));
                }
            endif;
        }
    }

    /*
     *  You can use this little method if you want to close the PDO connection
     *
     */

    public function CloseConnection()
    {
        # Set the PDO object to null to close the connection
        # http://www.php.net/manual/en/pdo.connections.php
        $this->pdo = null;
    }

    /**
     *  If the SQL query  contains a SELECT or SHOW statement it returns an array containing all of the result set row
     *   If the SQL statement is a DELETE, INSERT, or UPDATE statement it returns the number of affected rows
     *
     * @param string $query
     * @param array $params
     * @param int $fetchmode
     *
     * @return mixed
     */
    public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        /**
         * Debug mode : true | false
         */
        global $_DEBUG;
        if ($_DEBUG):
            $this->pdoDebug[] = [
                'query'  => $query,
                'params' => $params
            ];
        else:
            $this->pdoDebug;
        endif;
        $query = trim($query);

        $this->Init($query, $params);

        $rawStatement = explode(" ", $query);

        # Which SQL statement is used
        $statement = strtolower($rawStatement[0]);

        if ($statement === 'select' || $statement === 'show') {
            return $this->sQuery->fetchAll($fetchmode);
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->sQuery->rowCount();
        } elseif ($statement === 'create' || $statement === 'drop') {
            $_ERROR_CODES = $this->sQuery->errorInfo();
            switch ($_ERROR_CODES['0']):
                case '00000':
                    return true;
                    break;
                default :
                    if ($_DEBUG):
                        return json_encode(["code" => "2", "message" => $_ERROR_CODES['2']]);
                    else:
                        die(json_encode(["code" => "2", "message" => "Internal system error"]));
                    endif;
                    break;
            endswitch;
        } else {
            return null;
        }
    }

    /**
     *   Every method which needs to execute a SQL query uses this method.
     *
     *   1. If not connected, connect to the database.
     *   2. Prepare Query.
     *   3. Parameterize Query.
     *   4. Execute Query.
     *   5. Reset the Parameters.
     *
     * @param $query
     * @param $parameters
     */
    private function Init($query, $parameters = "")
    {
        /**
         * Debug mode : true | false
         */
        global $_DEBUG;

        /**
         * Connect to database
         */
        if (!$this->bConnected) {
            $this->Connect();
        }
        try {
            # Prepare query
            $this->sQuery = $this->pdo->prepare($query);

            # Add parameters to the parameter array
            $this->bindMore($parameters);

            # Bind parameters
            if (!empty($this->parameters)) {
                foreach ($this->parameters as $param) {
                    $parameters = explode("\x7F", $param);
                    $this->sQuery->bindParam($parameters[0], $parameters[1]);
                }
            }

            # Execute SQL
            $this->succes = $this->sQuery->execute();
        } catch (PDOException $e) {
            if ($_DEBUG):
                die(json_encode(["code" => "2", "message" => $e->getMessage()]));
            else:
                die(json_encode(["code" => "2", "message" => "Internal system error"]));
            endif;
        }

        # Reset the parameters
        $this->parameters = array();
    }

    /**
     * @void
     *
     *   Add more parameters to the parameter array
     *
     * @param array $parameters_array
     */
    public function bindMore($parameters_array)
    {
        if (empty($this->parameters) && is_array($parameters_array)) {
            $columns = array_keys($parameters_array);
            foreach ($columns as $i => &$column) {
                $this->bind($column, $parameters_array[$column]);
            }
        }
    }

    /**
     * @void
     *
     * Add the parameter to the parameter array
     *
     * @param string $para
     * @param string $value
     */
    public function bind($para, $value)
    {
        $this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . $value;
    }

    /**
     *  Returns the last inserted id.
     * @return string
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     *   Returns an array which represents a column from the result set
     *
     * @param string $query
     * @param array $params
     *
     * @return array
     */
    public function column($query, $params = null)
    {
        $this->Init($query, $params);
        $Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);

        $column = null;

        foreach ($Columns as $cells) {
            $column[] = $cells[0];
        }

        return $column;
    }

    /**
     *   Returns an array which represents a row from the result set
     *
     * @param string $query
     * @param array $params
     * @param int $fetchmode
     *
     * @return array
     */
    public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        $this->Init($query, $params);

        return $this->sQuery->fetch($fetchmode);
    }

    /**
     *   Returns the value of one single field/column
     *
     * @param string $query
     * @param array $params
     *
     * @return string
     */
    public function single($query, $params = null)
    {
        $this->Init($query, $params);

        return $this->sQuery->fetchColumn();
    }

}