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

    public function setResource($resource): self
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
                $this->resource = $this->related->{$this->getRelation()};
                break;
            case self::TYPE_VARIABLE:
                $this->resource = $this->model::find($this->related->{$this->getRelation()});
                break;
            case self::TYPE_STATIC:
                $this->resource = $this->model::find($this->related->{$this->key});
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

    public function relationship()
    {
        $this->type = self::TYPE_RELATION;
        return $this;
    }

    public function variable()
    {
        $this->type = self::TYPE_VARIABLE;
        return $this;
    }

    public function static()
    {
        $this->type = self::TYPE_STATIC;
        return $this;
    }
}
