<?php
/**
 * Includes various methods to establish a connection and communicate (or query) an SQL database.
 *
 * @package     Framework\IO\Adapters\SQL
 * @category    Adapters
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 * @version     $Id$
 * @copyright   2010-2016 Byrne-Systems
 */

namespace WAFFLE\Framework\Adapters;

use WAFFLE\Framework\IO\File;
use WAFFLE\Framework\Adapters\SQL;

/**
 * SQL Adapter
 *
 * Database class utilized for data access and manipulation
 */
class SQL {
    /**
     * @var             String $host                    The host address name (or location) for the database
     * @var             String $user                    The user-name to use while establishing a connection to the database
     * @var             String $pass                    The password to use while establishing a connection to the database
     * @var             String $db                      The name of the database to establish a connection with
     * @var             String $cxn                     Reserved location for the database connection Object
     */
    protected $host = "127.0.0.1";
    protected $user = "admin";
    protected $pass = "xNWLU3B69AhC2GBu";
    protected $db   = "byrne-systems";

    protected $cxn;                                     # Reserved: storage space for the "Database Connection" Object
    protected $File;                                    # Reserved: storage space for a 'File' Object

    /**
     * [description]
     *
     * @method void cxn_result(String $filename, Integer $r)
     *
     * @param           String  $filename               [description]
     * @param           Integer $r                      [description]
     */
    private function cxn_result($filename, $r) {
        switch ($r) {
            case 0:
                $content  = $this->get_date() . "[error] unable to successfully connect to database." . PHP_EOL;
                // $content .= $this->get_date() . "[action] terminating database connection." . PHP_EOL;
                break;
            case 1:
                $content  = $this->get_date() . "[success] a proper database connection was established!" . PHP_EOL;
                $content .= $this->get_date() . "Properly connected to " . $this->db . " database."  . PHP_EOL;
                $content .= $this->get_date() . "Host: " . mysqli_get_host_info($this->cxn)          . PHP_EOL;     // mysqli -> MySQL db only
                break;
        }

        $this->File->write($filename, $content, 'log');
    }

    /**
     * [description]
     *
     * @method void qry_result(String $filename, Integer $r)
     *
     * @param           String  $filename               [description]
     * @param           Integer $r                      [description]
     */
    private function qry_result($filename, $r) {
        switch ($r) {
            case 0:
                $content = $this->get_date() . "[error] unable to successfully query database."   . PHP_EOL;
                break;
            case 1:
                $content = $this->get_date() . "[success] query executed successfully" . PHP_EOL;
                break;
        }

        $this->File->write($filename, $content, 'log');
        $this->cxn->close();
    }

    /**
     * Get the current date for logging, indexing, or anything else requiring a current timestamp.
     *
     * @method String get_date()
     *
     * @return          String                          A string containing the current date and time; correctly formatted.
     */
    private function get_date() {
        date_default_timezone_set('America/Los_Angeles');
        return "[ " . date('l jS \of F Y h:i:s A') . "] ";
    }

    ####################################################################
    ###                          Public                              ###
    ####################################################################

    /**
     * Instantiate the $File (Object) and $cxn (Array)
     */
    public function __construct() {
        $this->File = new File;
        $this->cxn  = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        (!$this->cxn) ? $this->cxn_result("sql.db",0) : $this->cxn_result("sql_db",1);
    }

    /**
     * Generates a SELECT statement to query against the database, while returning the selected data
     * (or response).
     *
     * @method String select(String $table, String $where)
     *
     * @param           String $table                   Name of the table to access
     * @param           String $where                   A WHERE clause for the query
     * @return          String $response                The returned data (or response) obtained through querying the database with the generated SELECT statement.
     */
    public function select($table, $where) {
        try {

            $a = array();
            $w = "";

            foreach ($where as $key => $value) {
                $w .= " and " . $key . " like :" . $key;
                $a[":" . $key] = $value;
            }

            $stmt = $this->db->prepare("select * from " . $table . " where 1=1 " . $w);

            $stmt->execute($a);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($rows) <= 0) {
                $response["status"]  = "warning";
                $response["message"] = "No data found.";
            } else {
                $response["status"]  = "success";
                $response["message"] = "Data selected from database";
            }

            $response["data"] = $rows;

        } catch (PDOException $e) {

            $response["status"]  = "error";
            $response["message"] = 'Select Failed: ' . $e->getMessage();
            $response["data"]    = null;

        }

        return $response;
    }

    /**
     * Generates an INSERT statement to query against the database, while returning a response.
     *
     * @method String insert(String $table, Array $columnsArray, Array $requiredColumnsArray)
     *
     * @param           String $table                   Name of the table to access
     * @param           Array  $columnsArray            The name of the columns for the query executed
     * @param           Array  $requiredColumnsArray    Required Columns
     * @return          String $response                The response returned obtained through querying the database with the generated statement.
     */
    public function insert($table, $columnsArray, $requiredColumnsArray) {
        $this->verifyRequiredParams($columnsArray, $requiredColumnsArray);

        try {
            $a = array();
            $c = "";
            $v = "";

            foreach ($columnsArray as $key => $value) {
                $c .= $key . ", ";
                $v .= ":" . $key . ", ";
                $a[":" . $key] = $value;
            }

            $c = rtrim($c, ', ');
            $v = rtrim($v, ', ');

            $stmt = $this->db->prepare("INSERT INTO $table($c) VALUES($v)");

            $affected_rows = $stmt->rowCount();

            $response["status"]  = "success";
            $response["message"] = $affected_rows . " row inserted into database";
        } catch (PDOException $e) {
            $response["status"] = "error";
            $response["message"] = 'Insert Failed: ' . $e->getMessage();
        }

        return $response;
    }

    /**
     * Generates an UPDATE statement to query against the database, while returning a response.
     *
     * @method String update(String $table, Array $columnsArray, String $where, Array $requiredColumnsArray)
     *
     * @param           String $table                   Name of the table to access
     * @param           Array  $columnsArray            The name of the columns for the query executed
     * @param           String $where                   A WHERE clause for the query
     * @param           Array  $requiredColumnsArray    Required Columns
     * @return          String $response                The response returned obtained through querying the database with the generated statement.
     */
    public function update($table, $columnsArray, $where, $requiredColumnsArray) {
        $this->verifyRequiredParams($columnsArray, $requiredColumnsArray);

        try {
            $a = array();
            $w = "";
            $c = "";

            foreach($where as $key => $value) {
                $w .= " and " . $key . " = :" . $key;
                $a[":" . $key] = $value;
            }

            foreach ($columnsArray as $key => $value) {
                $c .= $key . " = :" . $key . ", ";
                $a[":" . $key] = $value;
            }

            $c = rtrim($c, ", ");

            $stmt = $this->db->prepare("UPDATE $table SET $c WHERE 1=1 " . $w);
            $stmt->execute($a);
            $affected_rows = $stmt->rowCount();

            if ($affected_rows<=0) {
                $response["status"]  = "warning";
                $response["message"] = "No row updated";
            } else {
                $response["status"]  = "success";
                $response["message"] = $affected_rows . " row(s) updated in database";
            }

        } catch (PDOException $e) {
            $response["status"]  = "error";
            $response["message"] = "Update Failed: " . $e->getMessage();
        }

        return $response;
    }

    /**
     * Generates a DELETE statement to query against the database, while returning a response
     *
     * @method String delete(String $table, String $where)
     *
     * @param           String $table                   Name of the table to access
     * @param           String $where                   A WHERE clause for the query
     * @return          String $response                The response returned obtained through querying the database with the generated statement.
     */
    public function delete($table, $where) {
        if (count($where) <= 0) {
            $response["status"]  = "warning";
            $response["message"] = "Delete Failed: At least one condition is required";
        } else {
            try {
                $a = array();
                $w = "";

                foreach ($where as $key => $value) {
                    $w .= " and " . $key . " = :" . $key;
                    $a[":" . $key] = $value;
                }

                $stmt = $this->db->prepare("DELETE FROM $table WHERE 1=1 " . $w);
                $stmt->execute($a);
                $affected_rows = $stmt->rowCount();

                if ($affected_rows<=0) {
                    $response["status"]  = "warning";
                    $response["message"] = "No row deleted";
                } else {
                    $response["status"]  = "success";
                    $response["message"] = $affected_rows . " row(s) deleted from database.";
                }

            } catch (PDOException $e) {
                $response["status"]  = "error";
                $response["message"] = 'Delete Failed: ' . $e->getMessage();
            }
        }

        return $response;
    }

    /**
     * Sanitize the data on the server-side to protect and validate the data for security.
     *
     * @method String verifyRequiredParams(Array $inArray, Array $requiredColumns)
     *
     * @param           Array  $inArray                 [description]
     * @param           Array  $requiredColumns         [description]
     * @return          String $response                [description]
     */
    private function verifyRequiredParams($inArray, $requiredColumns) {
        $error = false;
        $errorColumns = "";

        foreach ($requiredColumns as $field) {
            if (!isset($inArray[$field]) || strlen(trim($inArray[$field])) <= 0) {
                $error = true;
                $errorColumns .= $field . ', ';
            }
        }

        if ($error) {
            $response = array();
            $response["status"]  = "error";
            $response["message"] = 'Requird field(s) ' . rtrim($errorColumns, ', ') . 'is missing or empty';
            print_r($response);
            exit;
        }
    }

    /**
     * [description]
     *
     * @method String query(String $statement)
     *
     * @param           String $statement               The statement to be used to manipulate data in the database.
     */
    public function query($statement) {
        (!$this->cxn->query($statement)) ? $this->qry_result("sql_db",0) : $this->qry_result("sql_db",1);
    }
}