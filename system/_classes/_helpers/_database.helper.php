<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;

use function strpos;

class _CRUD extends _INIT
{
    public  $variables;
    public  $connSettings;
    private $db;

    public function __construct($data = array())
    {
        global $_CONNECTION;
        $this->db        = $_CONNECTION;
        $this->variables = $data;
    }

    public static function optionsFilter($var)
    {
        if ((strpos($var, 'condition') !== false) or (strpos($var, 'group_query') !== false) or (strpos($var, 'is_null') !== false)) {
            return false;
        } else {
            return $var;
        }
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (is_array($this->variables)) {
            if (array_key_exists($name, $this->variables)) {
                return $this->variables[$name];
            }
        }

        return null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (strtolower($name) === $this->key) {
            $this->variables[$this->key] = $value;
        } else {
            switch ($name) {
                case 'results':
                    $this->results = $value;
                    break;
                case 'options':
                    $this->options = $value;
                    break;
                default:
                    $this->variables[$name] = $value;
                    break;
            }
        }
    }

    /**
     * Data save
     */
    public function save($id = "0")
    {
        $useKey = (!empty(self::_options($this->connSettings)['key']) ? self::_options($this->connSettings)['key'] : $this->key);

        $this->variables[$useKey] = (empty($this->variables[$useKey])) ? $id : $this->variables[$useKey];
        $fieldsVals               = '';
        $columns                  = array_keys($this->variables);
        foreach ($columns as $column):
            if ($column !== $useKey) {
                $fieldsVals .= $column . " = :" . $column . ",";
            }
        endforeach;

        $fieldsVals = substr_replace($fieldsVals, '', -1);
        if (count($columns) > 1):
            $sql = "UPDATE " . $this->table . " SET " . $fieldsVals . " WHERE " . $useKey . "= :" . $useKey;
            if ($id === "0" && $this->variables[$useKey] === "0"):
                unset($this->variables[$useKey]);
                $sql = "UPDATE " . $this->table . " SET " . $fieldsVals;
            endif;

            return $this->exec($sql);
        endif;

        return null;
    }

    /**
     * @param $obj
     *
     * @return array
     */
    static private function _options($obj)
    {
        return [
            'key'          => isset($obj['key']) ? $obj['key'] : false,
            'select'       => isset($obj['select']) ? $obj['select'] : '*',
            'delete_key'   => isset($obj['delete_key']) ? $obj['delete_key'] : false,
            'delete_value' => isset($obj['delete_value']) ? $obj['delete_value'] : false,
        ];
    }

    /**
     * @param $sql
     * @param null $array
     *
     * @return mixed
     */
    public function exec($sql, $array = null)
    {
        if ($array !== null) {
            // Get result with the DB object
            $result = $this->db->query($sql, $array);
        } else {
            // Get result with the DB object
            $result = $this->db->query($sql, $this->variables);
        }

        // Empty bindings
        $this->variables = array();

        return $result;
    }

    /**
     * @return array
     */
    public function create()
    {
        $bindings = $this->variables;
        if (!empty($bindings)) {
            $fields     = array_keys($bindings);
            $fieldsVals = array(implode(",", $fields), ":" . implode(",:", $fields));
            $sql        = "INSERT INTO " . $this->table . " (" . $fieldsVals[0] . ") VALUES (" . $fieldsVals[1] . ")";
        } else {
            $sql = "INSERT INTO " . $this->table . " () VALUES ()";
        }

        return ['exec' => $this->exec($sql), 'id' => $this->db->lastInsertId()];
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function delete($id = "")
    {
        $id = (empty($this->variables[$this->key])) ? $id : $this->variables[$this->key];

        $delete_key   = self::_options($this->connSettings)['delete_key'];
        $delete_value = self::_options($this->connSettings)['delete_value'];

        $this->key = $delete_key ? $delete_key : $this->key;
        $id        = $delete_value ? $delete_value : $id;

        if (!empty($id)):
            $sql = "DELETE FROM " . $this->table . " WHERE " . $this->key . "= :" . $this->key;
        endif;

        return $this->exec($sql, array($this->key => $id));
    }

    /**
     * @param $table
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function deleteFrom($table, $key, $value)
    {
        return $this->exec("DELETE FROM " . $table . " WHERE " . $key . "= :" . $key, array($key => $value));
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function find($id = "")
    {
        $id = (empty($this->variables[$this->key])) ? $id : $this->variables[$this->key];

        if (!empty($id)):
            $sql = "SELECT " . self::_options($this->connSettings)['select'] . " FROM " . $this->table . " WHERE " . (!empty(self::_options($this->connSettings)['key']) ? self::_options($this->connSettings)['key'] : $this->key) . "= :" . (!empty(self::_options($this->connSettings)['key']) ? self::_options($this->connSettings)['key'] : $this->key) . " LIMIT 1";

            $result = $this->db->row($sql, array((!empty(self::_options($this->connSettings)['key']) ? self::_options($this->connSettings)['key'] : $this->key) => $id));

            return $result;
        endif;

        return false;
    }

    /**
     * @param array $_OPTIONS
     *
     * @return mixed
     */
    public function search($_OPTIONS = [])
    {

        $debug  = isset($_OPTIONS['debug']) ? $_OPTIONS['debug'] : false;
        $fields = isset($_OPTIONS['fields']) ? $_OPTIONS['fields'] : [];
        $sort   = isset($_OPTIONS['sort']) ? $_OPTIONS['sort'] : [];
        $limit  = isset($_OPTIONS['limit']) ? $_OPTIONS['limit'] : '';

        $join     = isset($_OPTIONS['join']) ? $_OPTIONS['join'] : '';
        $group_by = isset($_OPTIONS['group_by']) ? $_OPTIONS['group_by'] : '';

        $bindings = empty($fields) ? $this->variables : $fields;
        $sql      = "SELECT " . self::_options($this->connSettings)['select'] . " FROM " . $this->table;

        if (!empty($join)) {
            if (is_array($join) && !isset($join['mode'])) {
                foreach ($join as $item) {
                    $sql .= " " . $item['mode'] . ' ' . $item['table'] . (isset($item['as']) ? ' as ' . $item['as'] : '') . ' on ' . (isset($item['as']) ? '' . $item['as'] : $item['table']) . '.' . $item['conn_id'] . ' = ' . $this->table . '.' . (!empty(self::_options($this->connSettings)['key']) ? self::_options($this->connSettings)['key'] : $this->key);
                }
            } else {
                $sql .= " " . $join['mode'] . ' ' . $join['table'] . (isset($join['as']) ? ' as ' . $join['as'] : '') . ' on ' . (isset($join['as']) ? '' . $join['as'] : $join['table']) . '.' . $join['conn_id'] . ' = ' . $this->table . '.' . (!empty(self::_options($this->connSettings)['key']) ? self::_options($this->connSettings)['key'] : $this->key);
            }
        }

        if (!empty($bindings)) {
            $this->variables = array_filter($bindings, array($this, "optionsFilter"), ARRAY_FILTER_USE_KEY);
            $fieldsvals      = array();
            $columns         = array_keys($bindings);

            foreach ($columns as $column) {
                if ((strpos($column, 'condition') !== false) or strpos($column, 'group_query') !== false):
                    $fieldsvals [] = $_OPTIONS['fields'][$column]['value'];
                else:
                    if (is_array($_OPTIONS['fields'][$column])):
                        $fieldsvals [] = (isset($_OPTIONS['fields'][$column]['field_name']) ? $_OPTIONS['fields'][$column]['field_name'] : $column) . " " . (isset($_OPTIONS['fields'][$column]['type']) ? $_OPTIONS['fields'][$column]['type'] : '') . (isset($_OPTIONS['fields'][$column]['type']) ? " :" . $column : $_OPTIONS['fields'][$column]['value']);
                    else:
                        $fieldsvals [] = $column . " = :" . $column;
                    endif;
                endif;
            }

            $sql .= " WHERE " . implode(" ", $fieldsvals);
        }

        foreach ($this->variables as $key => $variable) {
            if (is_array($variable)) {
                $this->variables[$key] = $_OPTIONS['fields'][$key]['value'];
            }
        }

        if (!empty($group_by)) {
            $sql .= " GROUP BY " . $group_by;
        }

        if (!empty($sort)) {
            $sortvals = array();
            foreach ($sort as $key => $value) {
                $sortvals[] = $key . " " . $value;
            }
            $sql .= " ORDER BY " . implode(", ", $sortvals);
        }
        $sql .= empty($limit) ? '' : ' limit ' . $limit;

        if ($debug):
            echo '<pre>';
            echo $sql . "\n";
            print_r($this->variables);
            echo '</pre>';
        endif;

        return $this->exec($sql);
    }

    /**
     * @return mixed
     */
    public function distinct()
    {
        return $this->exec("SELECT DISTINCT " . self::_options($this->connSettings)['select'] . " FROM " . $this->table);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->exec("SELECT " . self::_options($this->connSettings)['select'] . " FROM " . $this->table);
    }

    /**
     * @param $field
     *
     * @return mixed
     */
    public function min($field)
    {
        if ($field) {
            return $this->db->single("SELECT min(" . $field . ")" . " FROM " . $this->table);
        }

        return false;
    }

    /**
     * @param $field
     *
     * @return mixed
     */
    public function max($field)
    {
        if ($field) {
            return $this->db->single("SELECT max(" . $field . ")" . " FROM " . $this->table);
        }

        return false;
    }

    /**
     * @param $field
     *
     * @return mixed
     */
    public function avg($field)
    {
        if ($field) {
            return $this->db->single("SELECT avg(" . $field . ")" . " FROM " . $this->table);
        }

        return false;
    }

    /**
     * @param $field
     *
     * @return mixed
     */
    public function sum($field)
    {
        if ($field) {
            return $this->db->single("SELECT sum(" . $field . ")" . " FROM " . $this->table);
        }

        return false;
    }

    /**
     * @param $field
     *
     * @return mixed
     */
    public function count($field)
    {
        if ($field) {
            return $this->db->single("SELECT count(" . $field . ")" . " FROM " . $this->table);
        }

        return false;
    }
}