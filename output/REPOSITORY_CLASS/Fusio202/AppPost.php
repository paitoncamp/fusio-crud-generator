<?php

/**
 * This file is auto-generated.
 */

namespace App\Repository\Fusio202;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

/**
 * Description of AppPost class from entity App_Post.
 */
class AppPost
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
		`ref_id`,
		`user_id`,
		`title`,
		`summary`,
		`content`,
		`insert_date`,
				FROM App_Post WHERE `id` = :id', [
		    'id' => $id,
		]);
	}


	public function insert(
		int $id,
		int $refId,
		int $userId,
		string $title,
		string $summary,
		string $content,
		datetime $insertDate
	): int {
		$this->connection->insert('App_Post', [
		'id'=>$id,
		'ref_id'=>$refId,
		'user_id'=>$userId,
		'title'=>$title,
		'summary'=>$summary,
		'content'=>$content,
		'insert_date'=>$insertDate,
		],[
		'id'=>$id
		]);
		return $id;
	}


	public function update(
		int $id,
		int $refId,
		int $userId,
		string $title,
		string $summary,
		string $content,
		datetime $insertDate
	): int {
		$this->connection->update('App_Post', [
		'id'=>$id,
		'ref_id'=>$refId,
		'user_id'=>$userId,
		'title'=>$title,
		'summary'=>$summary,
		'content'=>$content,
		'insert_date'=>$insertDate,
		],[
		'id'=>$id
		]);
		return $id;
	}


	public function delete(int $id): int
	{
		$this->connection->delete('App_Post', [
		'id'=>$id
		]);
		return $id;
	}
}
