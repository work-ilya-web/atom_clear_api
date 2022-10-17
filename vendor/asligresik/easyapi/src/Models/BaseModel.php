<?php

namespace asligresik\easyapi\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $selectColumn;

    public function search($search, $order = [], $concat = [], $user_id = false, $ids = [])
    {

        $join = $this->joinFields;
        //echo "<pre>"; print_r($join); echo "</pre>";
        //$this->table($this->table);
        if (!empty($join)) {
            $tables = '';

            foreach ($join as $field => $values) {
                $tables = $tables.((empty($tables))?'':',').$values['table'];
            }

            foreach ($join as $field => $values) {
                $this->select("$this->table.*, ".$values['fields']);
                $this->join($values['table'].' AS '.$values['alias'], $field.' = '.$values['alias'].'.id', 'left');
            }
        }


        //$this->from($tables);
        if (!empty($concat)) {
            foreach ($concat as $name => $field) {
                if(is_array($field)){
                    foreach ($field as $k => $v) {
                        $fields = explode(',',$k);
                        if(count($fields)>1){
                            $hasLikeExpression = $this->getLikeExpression($v);
                            $this->like('CONCAT('.$k.')', str_replace('|','',$v));
                        }
                    }
                }
            }
        }



        if (!empty($search)) {
            foreach ($search as $k => $v) {
                if (is_array($v)) {
                    $this->where($k.' between '.$this->escape($v['start']).' and '.$this->escape($v['end']));
                } else {
                    $hasLikeExpression = $this->getLikeExpression($v);
                    if (!is_null($hasLikeExpression)) {
                        $this->like($k, str_replace('|','',$v), $hasLikeExpression);
                    } else {
                        $this->where($k, $v);
                    }
                }
            }
        }

        if (!empty($ids)) {
            $where = '';
            foreach ($ids as $key=>$id) {
                $where .= "(".$this->table.".id = ".$id.")";
                if(isset($ids[$key+1])){
                    $where .= " OR ";
                }
            }
            $where = " (".$where.")";
            $this->where($where);
        }




        if (!empty($order)) {
            $order = is_array($order) ? $order : [$order => 'ASC'];
            foreach ($order as $k => $v) {
                $this->orderBy($k, $v);
            }
        }

        //echo "<pre>"; print_r($this->getCompiledSelect()); echo "</pre>";
        return $this;
    }


    public function find_id($id){

        $join = $this->joinFields;
        if (!empty($join)) {
            $tables = '';

            foreach ($join as $field => $values) {
                $tables = $tables.((empty($tables))?'':',').$values['table'];
            }

            foreach ($join as $field => $values) {
                $this->select("$this->table.*, ".$values['fields']);
                $this->join($values['table'].' AS '.$values['alias'], $field.' = '.$values['alias'].'.id', 'left');
            }
        }

        return $this->find($id);
    }

    /**
     * Inserts data into the current table. If an object is provided,
     * it will attempt to convert it to an array.
     *
     * @param array|object $data
     * @param bool         $returnID whether insert ID should be returned or not
     *
     * @throws \ReflectionException
     *
     * @return BaseResult|false|int|string
     */
    public function insert($data = null, bool $returnID = true)
    {
        $this->setValidationRulesCreated();

        return parent::insert($data, $returnID);
    }

    /**
     * Updates a single record in $this->table. If an object is provided,
     * it will attempt to convert it into an array.
     *
     * @param array|int|string $id
     * @param array|object     $data
     *
     * @throws \ReflectionException
     */
    public function update($id = null, $data = null): bool
    {
        $this->setValidationRulesUpdated($data);

        return parent::update($id, $data);
    }

    public function update_not_id($id = null, $data = null): bool
    {
        return parent::update($id, $data);
    }

    /**
     * Get the value of selectColumn.
     */
    public function getSelectColumn()
    {
        return $this->selectColumn;
    }

    /**
     * Set the value of selectColumn.
     *
     * @param mixed $selectColumn
     *
     * @return self
     */
    public function setSelectColumn($selectColumn)
    {
        $this->selectColumn = $selectColumn;

        return $this;
    }

    public function builder(string $table = null)
    {
        $builder = parent::builder($table);
        if ($this->getSelectColumn()) {
            $builder->select($this->getSelectColumn());
        }

        return $builder;
    }

    protected function setValidationRulesCreated()
    {
        $exceptColumn = [$this->primaryKey];
        if ($this->useTimestamps && !empty($this->createdField)) {
            array_push($exceptColumn, $this->createdField);
        }

        if ($this->useTimestamps && !empty($this->updatedField)) {
            array_push($exceptColumn, $this->updatedField);
        }
        $this->setValidationRules($this->getValidationRules(['except' => $exceptColumn]));
    }

    protected function setValidationRulesUpdated($data)
    {
        $this->setValidationRules($this->getValidationRules(['only' => array_keys($data)]));
    }

    private function getLikeExpression(string $value)
    {
        $position = 0;
        $firstCharacter = '|' == substr($value, 0, 1) ? 1 : 0;
        $endCharacter = '|' == substr($value, -1, 1) ? 2 : 0;
        $position = $position + $firstCharacter + $endCharacter;
        switch ($position) {
            case 1:
                return 'before';

                break;
            case 2:
                return 'after';

                break;
            case 3:
                return 'both';

                break;
            default:
                return null;
        }
    }
}
