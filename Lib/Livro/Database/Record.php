<?php

abstract class Record implements RecordInterface
{
    protected $data = [];

    public function __construct($id = null)
    {
        if ($id !== null) {
            $object = $this->load($id);

            if ($object) {
                $this->fromArray($object->toArray());
            }
        }
    }

    public function __clone()
    {
        unset($this->data['id']);
    }

    public function __set($prop, $value)
    {
        if (method_exists($this, 'set_' . $prop)) {
            call_user_func([$this, 'set_' . $prop], $value);
            return;
        }

        if ($value === null) {
            unset($this->data[$prop]);
            return;
        }

        $this->data[$prop] = $value;
    }

    public function __get($prop)
    {
        if (method_exists($this, 'get_' . $prop)) {
            return call_user_func([$this, 'get_' . $prop]);
        }

        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $prop)));

        if (method_exists($this, $method)) {
            return call_user_func([$this, $method]);
        }

        return $this->data[$prop];
    }

    public function __isset($prop)
    {
        return isset($this->data[$prop]);
    }

    public function getEntity()
    {
        $class = get_class($this);

        return constant("{$class}::TABLENAME");
    }

    public function fromArray($data)
    {
        $this->data = (array) $data;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function load($id)
    {
        if ($conn = Transaction::get()) {
            $sql = "SELECT * FROM {$this->getEntity()} WHERE id = " . (int) $id;

            Transaction::log($sql);

            $result = $conn->query($sql);

            if ($result) {
                $data = $result->fetch(PDO::FETCH_ASSOC);

                if ($data) {
                    $class = get_class($this);
                    $object = new $class();
                    $object->fromArray($data);

                    return $object;
                }
            }

            return null;
        }

        throw new Exception('Não há transação ativa!');
    }

    public function store()
    {
        $prepared = $this->prepare($this->data);

        if (empty($this->data['id']) || !$this->load($this->id)) {
            if (empty($this->data['id'])) {
                $this->id = $this->getLast() + 1;
                $prepared['id'] = $this->id;
            }

            $sql = "INSERT INTO {$this->getEntity()} " .
                '(' . implode(', ', array_keys($prepared)) . ')' .
                ' VALUES ' .
                '(' . implode(', ', array_values($prepared)) . ')';
        } else {
            $set = [];

            foreach ($prepared as $column => $value) {
                if ($column !== 'id') {
                    $set[] = "{$column} = {$value}";
                }
            }

            if (empty($set)) {
                return 0;
            }

            $sql = "UPDATE {$this->getEntity()}";
            $sql .= ' SET ' . implode(', ', $set);
            $sql .= ' WHERE id = ' . (int) $this->data['id'];
        }

        if ($conn = Transaction::get()) {
            Transaction::log($sql);

            return $conn->exec($sql);
        }

        throw new Exception('Não há transação ativa!');
    }

    public function delete($id = null)
    {
        $id = $id ?: $this->id;

        $sql = "DELETE FROM {$this->getEntity()}";
        $sql .= ' WHERE id = ' . (int) $id;

        if ($conn = Transaction::get()) {
            Transaction::log($sql);

            return $conn->exec($sql);
        }

        throw new Exception('Não há transação ativa!');
    }

    private function getLast()
    {
        if ($conn = Transaction::get()) {
            $sql = "SELECT max(id) FROM {$this->getEntity()}";

            Transaction::log($sql);

            $result = $conn->query($sql);
            $row = $result->fetch();

            return $row[0];
        }

        throw new Exception('Não há transação ativa!');
    }

    public static function all()
    {
        $classname = get_called_class();
        $repository = new Repository($classname);

        return $repository->load(new Criteria());
    }

    public static function find($id)
    {
        $classname = get_called_class();
        $record = new $classname();

        return $record->load($id);
    }

    public function prepare($data)
    {
        $prepared = [];

        foreach ($data as $key => $value) {
            if (is_scalar($value)) {
                $prepared[$key] = $this->escape($value);
            }
        }

        return $prepared;
    }

    public function escape($value)
    {
        if (is_string($value) && $value !== '') {
            $value = str_replace("'", "''", $value);

            return "'{$value}'";
        }

        if (is_bool($value)) {
            return $value ? 'TRUE' : 'FALSE';
        }

        if ($value !== '') {
            return $value;
        }

        return 'NULL';
    }
}