<?php

namespace Newnet\Core\Repository;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface {

    protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function paginate($itemOnPage) {
        return $this->model->paginate($itemOnPage);
    }

    public function getAll() {
        return $this->model->all();
    }

    public function getById($id) {
        return $this->model->findOrFail($id);
    }

    public function destroy($value)
    {
        return $this->model->destroy($value);
    }
}

?>
