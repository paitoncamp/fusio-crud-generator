<?php

/**
 * This file is auto-generated.
 */

namespace App\Repository\FusioCms;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

/**
 * Description of AppPage class from entity app_page.
 */
class AppPage
{
	/** @var Connection */
	private $connection;


	public function __construct()
	{
	}


	public function setupConnection(Connection $connection)
	{
		$this->connection=$connection;
	}


	public function findById(int $id)
	{
		return $this->connection->fetchAssoc('
		SELECT
		`id`,
		`parent_id`,
		`user_id`,
		`status`,
		`sort`,
		`title`,
		`data`,
		`insert_date`,
				FROM app_page WHERE `id` = :id', [
		    'id' => $id,
		]);
	}


	public function insert(
		int $id,
		int $parentId,
		int $userId,
		int $status,
		int $sort,
		string $title,
		json $data,
		datetime $insertDate
	): int {
		$this->connection->insert('app_page', [
		'id'=>$id,
		'parent_id'=>$parentId,
		'user_id'=>$userId,
		'status'=>$status,
		'sort'=>$sort,
		'title'=>$title,
		'data'=>$data,
		'insert_date'=>$insertDate,
		],[
		'id'=>$id
		]);
		return $id;
	}


	public function update(
		int $id,
		int $parentId,
		int $userId,
		int $status,
		int $sort,
		string $title,
		json $data,
		datetime $insertDate
	): int {
		$this->connection->update('app_page', [
		'id'=>$id,
		'parent_id'=>$parentId,
		'user_id'=>$userId,
		'status'=>$status,
		'sort'=>$sort,
		'title'=>$title,
		'data'=>$data,
		'insert_date'=>$insertDate,
		],[
		'id'=>$id
		]);
		return $id;
	}


	public function delete(int $id): int
	{
		$this->connection->delete('app_page', [
		'id'=>$id
		]);
		return $id;
	}
}
