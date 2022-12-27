<?php

namespace Newnet\Core\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /** @var Model|\Eloquent $model */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function paginate($itemOnPage)
    {
        return $this->model->paginate($itemOnPage);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function findMany($ids, $columns = ['*'])
    {
        return $this->model->findMany($ids, $columns);
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function destroy($value)
    {
        return $this->model->destroy($value);
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $condition, array $data)
    {
        return $this->model->where($condition)->update($data);
    }

    public function updateById(array $data, $id)
    {
        $model = $this->find($id);

        $model->update($data);

        return $model;
    }

    public function updateOrCreate(array $attributes, $value = [])
    {
        return $this->model->updateOrCreate($attributes, $value);
    }
}
