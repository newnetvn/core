<?php
namespace Newnet\Core\Repository;

interface BaseRepositoryInterface {
    public function paginate($itemOnPage);
    public function getAll();
    public function getById($id);
    public function destroy($value);
}

?>
