<?php

use Livro\Database\Record;
use Livro\Database\Criteria;
use Livro\Database\Repository;

class Pessoa extends Record
{
    const TABLENAME = 'pessoa';
    private $cidade;

    public function getCidade()
    {
        if (empty($this->cidade)) {
            $this->cidade = new Cidade($this->id_cidade);
        }

        return $this->cidade;
    }

    public function getNomeCidade()
    {
        return $this->getCidade()->nome;
    }

    public function addGrupo(Grupo $grupo)
    {
        $pg = new PessoaGrupo();
        $pg->id_grupo = $grupo->id;
        $pg->id_pessoa = $this->id;
        $pg->store();
    }

    public function deleteGrupo()
    {
        $criteria = new Criteria();
        $criteria->add('id_pessoa', '=', $this->id);

        $repo = new Repository('PessoaGrupo');

        return $repo->delete($criteria);
    }

    public function getGrupos()
    {
        $grupos = [];

        $criteria = new Criteria();
        $criteria->add('id_pessoa', '=', $this->id);

        $repo = new Repository('PessoaGrupo');
        $vinculos = $repo->load($criteria);

        if ($vinculos) {
            foreach ($vinculos as $vinculo) {
                $grupos[] = new Grupo($vinculo->id_grupo);
            }
        }

        return $grupos;
    }

    public function getIdsGrupos()
    {
        $grupos_ids = [];
        $grupos = $this->getGrupos();

        if ($grupos) {
            foreach ($grupos as $grupo) {
                $grupos_ids[] = $grupo->id;
            }
        }

        return $grupos_ids;
    }

    public function delete($id = null)
    {
        $criteria = new Criteria();
        $criteria->add('id_pessoa', '=', $this->id);

        $repo = new Repository('PessoaGrupo');
        $repo->delete($criteria);

        parent::delete();
    }

    public function getContasEmAberto()
    {
        return Conta::getByPessoa($this->id);
    }

    public function totalDebitos()
    {
        $total = 0;
        $contas = $this->getContasEmAberto();

        if ($contas) {
            foreach ($contas as $conta) {
                $total += $conta->valor;
            }
        }

        return $total;
    }
}
