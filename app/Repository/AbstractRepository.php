<?php


namespace App\Repository;


use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectFilter($fields)
    {
        print($fields);
        $this->model = $this->model->selectRaw($fields);
    }

    public function selectConditions($conditions)
    {
        print_r($conditions);
        $expressions = explode(';', $conditions);
        foreach ($expressions as $e) {
            $exp = explode(':', $e);
            $this->model = $this->model->where($exp[0], $exp[1], $exp[2]);
        }
    }

    public function getResult()
    {
        return $this->model;
    }
}
