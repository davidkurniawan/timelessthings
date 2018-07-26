<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
 Copyright 2012 by wildan
 shapetherapy@gmail.com
 */
if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found");
    exit ;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

class QueryHistory {
    private static $lastQuery, $savedQueries = array();

    static function setLastQuery($provider, $sql) {
        self::$lastQuery = array('provider' => $provider, 'sql' => $sql);
    }

    static function getLastQuery($key = null) {
        $key = empty($key) ? 'sql' : $key;
        return isset(self::$lastQuery[$key]) ? self::$lastQuery[$key] : '';
    }

    static function addQuery($provider, $sql, $time) {
        self::$savedQueries[] = array('provider' => $provider, 'sql' => $sql, 'time' => sprintf('%.5f', $time));
    }

    static function numQueries() {
        return count(self::$savedQueries);
    }

    static function queries() {
        return self::$savedQueries;
    }

}

abstract class DataProvider extends ObjectBase {
    protected $_host, $_user, $_password, $_handle, $_result, $_database, $_prefix = '', $_port;

    protected function __construct($database, $host, $user, $password, $port = null) {
        $this -> _host = $host;
        $this -> _user = $user;
        $this -> _password = $password;
        $this -> _database = $database;
        $this -> _port = $port;
    }

    static function createConnection($dsn) {

        if (empty($dsn) && defined(DB_NAME)) {
            return new $dblayer(DB_NAME, DB_HOST, DB_USER, DB_PASS, defined(DB_PORT) ? DB_PORT : null);
        } else {
            if (strpos($dsn, 'sqlite:') === 0) {
                $dbfile = substr($dsn, 8);
                return new Sqlite($dbfile, null, '', '', null);
            } else {
                $part = parse_url($dsn);
                $pass = isset($part['pass']) ? $part['pass'] : '';

                if (!isset($part['host']) || !isset($part['scheme']) || !isset($part['path'])) {
                    //the correct dsn: &lt;driver&gt;://[[&lt;user&gt;][:&lt;pass&gt;]@]&lt;host&gt;[:&lt;port&gt;]/&lt;database&gt;[#&lt;table_prefix&gt;]

                    $errdsn = empty($pass) ? $dsn : str_replace($pass, "[pass]", $dsn);
                    trigger_error("Invalid connection string $errdsn", E_USER_WARNING);
                }

                $database = trim($part['path'], '/');
                $dblayer = ucfirst($part['scheme']);

                $instance = new $dblayer($database, $part['host'], isset($part['user']) ? $part['user'] : '', $pass, isset($part['port']) ? $part['port'] : null);

                if (isset($part['fragment'])) {
                    $instance -> tableNamePrefix = $part['fragment'];
                }

                return $instance;
            }
        }
    }

    protected function get__tableNamePrefix() {
        return $this -> _prefix;
    }

    protected function set__tableNamePrefix($value) {
        $this -> _prefix = $value;
    }

    protected function get__host() {
        return $this -> _host;
    }

    protected function get__database() {
        return $this -> _database;
    }

    protected function get__user() {
        return $this -> _user;
    }

    protected function get__handle() {
        return $this -> _handle;
    }

    abstract protected function get__providerName();
    abstract protected function onOpen($persistent = false);
    abstract protected function onClose();
    abstract protected function onSelectDb();
    abstract public function escape($str);
    abstract public function beginTrans();
    abstract public function commitTrans();
    abstract public function rollBackTrans();
    abstract public function numRows($result = null);
    abstract public function insertId($link_id = null);
    abstract public function fetchResult($result = null, $row = 0, $field = 0);
    abstract public function fetchAssoc($result = null);
    abstract public function fetchRow($result = null);
    abstract public function seek($index, $result = null);
    abstract public function affectedRows($result = null);
    abstract public function errorDescription();

    public function quote($str) {
        return "'" . $this -> escape($str) . "'";
    }

    public function fetchActiveRecord($base_table, $result = null) {
        $result = is_null($result) ? $this -> _result : $result;
        if ($row = $this -> fetchAssoc($result)) {
            return new ActiveRecord($base_table, $row);
        }
        return false;
    }

    public function open($persistent = false) {
        if (is_resource($this -> _handle)) {
            return;
        }
        $this -> _handle = $this -> onOpen($persistent) or trigger_error("Failed  to connect to " . $this -> get__providerName() . " for: '" . (empty($this -> _user) ? $this -> _user : 'anonymous') . "@" . $this -> _host . "' (Using password: " . (empty($this -> _password) ? 'NO' : 'YES') . ")", E_USER_WARNING);

        if (false === $this -> onSelectDb()) {
            $this -> close();
            trigger_error("Unable to select database '" . $this -> _database . "'", E_USER_ERROR);
        }
    }

    public function close() {
        if (is_resource($this -> _handle)) {
            return $this -> onClose();
        }
        return false;
    }

    public function query($sql) {
        $sql = str_replace('#__', $this -> _prefix, $sql);
        if (defined('DEBUG_MODE')) {
            $q_start = getMicrotime();
            QueryHistory::setLastQuery($this -> providerName, $sql);
        }
        $this -> _result = $this -> onQuery($sql) or trigger_error('E_DB~' . $this -> errorDescription(), E_USER_ERROR);

        if (defined('DEBUG_MODE'))
            QueryHistory::addQuery($this -> providerName, $sql, getMicrotime() - $q_start);

        return $this -> _result;
    }

    public function executeMultipleQuery($sqltext) {
        if (empty($sqltext))
            return false;
        $this -> _executeMultipleQuery(new DataStream($sqltext, 0));
    }

    public function executeFile($file) {
        if ($stream = File::open($file)) {
            $this -> _executeMultipleQuery($stream);
            $stream -> close();
        }
        return false;
    }

    private function _executeMultipleQuery($stream) {
        $query = '';
        while (!$stream -> eof()) {
            $line = trim($stream -> readLine());
            if ($line == '')
                continue;
            // skip empty line
            if (substr($line, 0, 2) != '--')// skip comment line
            {
                $query .= $line;
                if ($line[strlen($line) - 1] == ';') {
                    $this -> query($query);
                    $query = '';
                }
            }
        }
    }

    public function getPrimaryKey($table) {
        if (!empty($table)) {
            if ($row = $this -> getRow("SHOW COLUMNS FROM $table where `Key`='PRI' and Extra='auto_increment'", false)) {
                return $row['Field'];
            } else {
                if ($rows = $this -> getDataRows("SHOW COLUMNS FROM $table")) {
                    foreach ($rows as $row) {
                        if ($row['Key'] == 'PRI' && $row['Extra'] == 'auto_increment')
                            return $row['Field'];
                    }
                }
            }
        }
        return null;
    }

    public function getResult($sql, $row = 0) {
        if ($result = $this -> query($sql)) {
            return $this -> fetchResult($result, $row);
        }
        return false;
    }

    //DEPRECATED
    public function getDataRow($sql, $limit_once = true) {
        return $this -> getRow($sql, $limit_once);
    }

    //DEPRECATED
    public function getDataRows($sql, $key = null, $value = null) {
        return $this -> getRows($sql, $key, $value);
    }

    //DEPRECATED
    public function getObjectRow($sql, $limit_once = true) {
        return $this -> getObject($sql, $limit_once);
    }

    //DEPRECATED
    public function getObjectRows($sql) {
        return $this -> getObjects($sql);
    }

    public function getRow($sql, $limit_once = true) {
        if ($result = $this -> query($sql . ($limit_once ? ' limit 0,1' : ''))) {
            return $this -> fetchAssoc($result);
        }
        return false;
    }

    public function getRows($sql, $key = null, $value = null) {
        if ($result = $this -> query($sql)) {
            $rows = array();
            if (!empty($key)) {
                while ($row = $this -> fetchAssoc($result))
                    $rows[$row[$key]] = is_null($value) ? $row : $row[$value];
            } else {
                while ($row = $this -> fetchAssoc($result))
                    $rows[] = $row;
            }
            return $rows;
        }
        return false;
    }

    public function getObject($sql, $limit_once = true) {
        if ($result = $this -> query($sql . ($limit_once ? ' limit 0,1' : ''))) {
            if ($row = $this -> fetchAssoc($result))
                return new Object($row, false);
        }
        return false;
    }

    public function getObjects($sql) {
        if ($result = $this -> query($sql)) {
            $rows = array();
            while ($row = $this -> fetchAssoc($result)) {
                $rows[] = new Object($row, false);
            }
            return $rows;
        }
        return false;
    }

    public function getActiveRecord($sql, $base_table = null) {

        if ($result = $this -> query($sql)) {
            if (is_null($base_table))
                $base_table = $this -> firstTable($sql);
            return $this -> fetchActiveRecord($base_table, $result);
        }
        return false;
    }

    public function getActiveRecords($sql, $base_table = null) {
        if ($result = $this -> query($sql)) {
            if (is_null($base_table))
                $base_table = $this -> firstTable($sql);

            $rows = array();
            while ($row = $this -> fetchActiveRecord($base_table, $result)) {
                $rows[] = $row;
            }
            return $rows;
        }
        return false;
    }

    public function getHierarchicalDataRows($sql, $parentRelationField = 'parent', $primaryKey = 'id', $fetch_callback = null) {
        return $this -> _getHierarchicalDataRows($sql, $parentRelationField, $primaryKey, $fetch_callback, false);
    }

    public function getHierarchicalObjectRows($sql, $parentRelationField = 'parent', $primaryKey = 'id', $fetch_callback = null) {
        return $this -> _getHierarchicalDataRows($sql, $parentRelationField, $primaryKey, $fetch_callback, true);
    }

    private function _getHierarchicalDataRows($sql, $parentRelationField, $primaryKey, $fetch_callback, $fetch_objects = false) {
        if ($result = $this -> query($sql)) {
            $roots = array();
            $children = array();
            $retval = array();
            while ($row = $this -> fetchAssoc($result)) {
                if (is_callable($fetch_callback))
                    //$row =
                    $fetch_callback($row);
                if (!isset($row[$parentRelationField]))
                    return null;
                if ($row['parent'] != 0)
                    $children[$row[$parentRelationField]][] = $row;
                else
                    $roots[$row[$primaryKey]] = $row;
            }
            foreach ($roots as $key => $row) {
                $haschildren = isset($children[$row[$primaryKey]]);
                $row['children'] = ($haschildren) ? $this -> _getHierarchicalchildren($children, $children[$row[$primaryKey]], $parentRelationField, $primaryKey, $fetch_objects) : array();
                $retval[] = $fetch_objects ? new Object($row, false) : $row;
            }
            return $retval;
        }
        return false;
    }

    private function _getHierarchicalchildren($allchildren, $children, $parentRelationField, $primaryKey, $fetch_objects = false) {
        $retval = array();
        foreach ($children as $row) {
            $haschildren = isset($allchildren[$row[$primaryKey]]);
            $row['children'] = ($haschildren) ? $this -> _getHierarchicalchildren($allchildren, $allchildren[$row[$primaryKey]], $parentRelationField, $primaryKey, $fetch_objects) : array();
            $retval[] = $fetch_objects ? new Object($row, false) : $row;
        }
        return $retval;
    }

    public function getChildrenId($table, $id, $include_root = true, $parentRelationField = 'parent', $primaryKey = 'id') {

        if ($result = $this -> query("SELECT $primaryKey,$parentRelationField FROM $table where $parentRelationField=" . $id)) {
            $retval = $include_root ? array($id) : array();
            while ($row = $this -> fetchAssoc($result)) {
                $retval[] = $row[$primaryKey];
                if ($rows = $this -> queryGetChildIds($table, $row[$primaryKey], false, $parentRelationField, $primaryKey)) {
                    $retval = array_merge($retval, $rows);
                }
            }
            return $retval;
        }
        return null;
    }

    public function getInsertCommand($table, array $datarow) {
        $_1 = 'INSERT INTO ' . $table . ' (';
        $_2 = ' VALUES (';
        $_ = '';
        foreach ($datarow as $key => $value) {
            if (is_array($value) || is_object($value))
                $value = serialize($value);
            $_1 .= $_ . $key;
            $_2 .= $_ . "'" . $this -> escape($value) . "'";
            $_ = ',';
        }
        $_1 .= ")\n";
        $_2 .= ')';
        return $_1 . $_2;
    }

    private function sqlUpdateFromArray(array $datarow) {
        $str = '';
        $_ = '';
        foreach ($datarow as $key => $value) {
            if (is_array($value))
                $value = serialize($value);
            $str .= $_ . $key . "='" . $this -> escape($value) . "'";
            $_ = ',';
        }
        return $str;
    }

    public function getUpdateCommand($table, array $datarow, $where = '') {
        $sql = 'UPDATE ' . $table . "\nSET " . $this -> sqlUpdateFromArray($datarow);
        return $sql . (empty($where) ? '' : "\nWHERE " . $where);
    }

    public function getUpdateCommand2($table, array $datarow, $where = '') {
        $sql = 'UPDATE ' . $table . "\nSET ";
        $_ = '';
        foreach ($datarow as $key => $value) {
            if (is_array($value))
                $value = serialize($value);
            $sql .= $_ . $key . "='" . $this -> escape($value) . "'";
            $_ = ',';
        }
        return $sql . (empty($where) ? '' : "\nWHERE " . $where);
    }

    /*	public function updateRows33($table,array $datarow, $where='')
     {
     return $this->query( $this->getUpdateCommand($table,$datarow, $where));
     }*/
    public function updateRows($table, array $datarow, $where = '', $insert = false) {
        //echo $this->getUpdateCommand($table,$datarow, $where);
        $retval = $this -> query($this -> getUpdateCommand($table, $datarow, $where));
        if ($insert && empty($retval)) {
            $this -> insertRow($table, $datarow);
            $retval = $this -> insertId ? 1 : 0;
        }
        return $retval;
    }

    public function deleteRows($table, $where = '') {
        return $this -> query('DELETE FROM ' . $table . ($where ? '  WHERE ' . $where : ''));
    }

    public function insertRow($table, array $datarow, $duplicate_key_update_data = null) {
        $sql = $this -> getInsertCommand($table, $datarow);
        if (is_array($duplicate_key_update_data)) {
            $sql .= "\nON DUPLICATE KEY UPDATE " . $this -> sqlUpdateCmdFromArray($duplicate_key_update_data);
        }
        return $this -> query($sql);
    }

    private function firstTable($sql) {
        if (preg_match('#FROM([\s\(]+)([\#a-zA-z0-9_\.]*)([\s])#i', $sql, $match)) {
            return $match[2];
        }
        return null;
    }

}
?>