<?php

namespace Traits;

use Action;
use Livro\Database\Transaction;
use Livro\Widgets\Dialog\Message;
use Livro\Widgets\Dialog\Question;

trait DeleteTrait
{
    function onDelete($param)
    {
        $id = $param['id'];
        $action1 = new Action([$this, 'delete']);
        $action1->setParameter('id', $id);

        new Question('Deseja deletar o registro?', $action1);
    }

    function delete($param)
    {
        try {
            $id = $param['id'];
            Transaction::open($this->connection);
            $class = $this->activeRecord;
            $object = $class::find($id);
            $object->delete();
            Transaction::close();
            $this->onReload();
            new Message('info', 'Registro excluído com sucesso!');
        } catch (Exception $e) {
            new Message('error', $e->getMessage());
        }
    }
}
