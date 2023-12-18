<?php

namespace Abather\MiniAccounting\Objects;

class Account
{
    protected $type;
    protected $model;
    protected $resource;
    protected $relation;
    protected $key;
    protected $caller;
    const TYPE_RELATION = "relation";
    const TYPE_VARIABLE = "variable";
    const TYPE_STATIC = "static";

    public function __construct($model, $caller, $resource = null)
    {
        $this->caller = $caller;
        $this->model = $model;
        $this->resource = $resource;
    }

    public static function make($model, $caller, $resource = null)
    {
        return new static($model, $caller);
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource = null): self
    {
        if (filled($resource)) {
            //throw an error if the resource is not an instance of the model
            throw_if(!($this->resource instanceof $this->model),
                new \Exception("Resource must be an instance of the model {$this->model}"));
            $this->resource = $resource;
            return $this;
        }

        if (filled($this->resource) && $this->resource instanceof $this->model) {
            return $this;
        }

        switch ($this->type) {
            case self::TYPE_RELATION:
                $this->resource = $this->getCaller()->{$this->getRelation()};
                break;
            case self::TYPE_VARIABLE:
                $this->resource = $this->model::find($this->getCaller()->{$this->getRelation()});
                break;
            case self::TYPE_STATIC:
                $this->resource = $this->model::find($this->key);
                break;
        }

        return $this;
    }

    public function getRelation()
    {
        return $this->relation;
    }

    public function setRelation($relation): self
    {
        $this->relation = $relation;
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key): self
    {
        $this->key = $key;
        return $this;
    }

    public function getCaller()
    {
        return $this->caller;
    }

    public function relationship($relation)
    {
        $this->type = self::TYPE_RELATION;
        $this->relation = $relation;
        return $this;
    }

    public function variable($varible)
    {
        $this->type = self::TYPE_VARIABLE;
        $this->relation = $varible;
        return $this;
    }

    public function static($key)
    {
        $this->type = self::TYPE_STATIC;
        $this->key = $key;
        return $this;
    }
}
