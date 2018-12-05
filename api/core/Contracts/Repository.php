<?php
namespace Core\Contracts;

interface Repository
{
	public function create(array $data);
	public function update(array $data, $id);
	public function delete($entityE);
	public function insert($entityE);

	public function find($id);
	public function findAll();
	public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
	public function findOneBy(array $criteria, array $orderBy = null);

	//protected function getEntityName();
	public function getClassName();
}
