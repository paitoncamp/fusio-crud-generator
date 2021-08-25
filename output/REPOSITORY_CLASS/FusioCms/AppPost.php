<?php

/**
 * This file is auto-generated.
 */

namespace App\Repository\FusioCms;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

/**
 * Description of AppPost class from entity app_post.
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
		`page_id`,
		`user_id`,
		`status`,
		`title`,
		`summary`,
		`content`,
		`insert_date`,
				FROM app_post WHERE `id` = :id', [
		    'id' => $id,
		]);
	}


	public function insert(
		int $id,
		int $pageId,
		int $userId,
		int $status,
		string $title,
		string $summary,
		string $content,
		datetime $insertDate
	): int {
		$this->connection->insert('app_post', [
		'id'=>$id,
		'page_id'=>$pageId,
		'user_id'=>$userId,
		'status'=>$status,
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
		int $pageId,
		int $userId,
		int $status,
		string $title,
		string $summary,
		string $content,
		datetime $insertDate
	): int {
		$this->connection->update('app_post', [
		'id'=>$id,
		'page_id'=>$pageId,
		'user_id'=>$userId,
		'status'=>$status,
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
		$this->connection->delete('app_post', [
		'id'=>$id
		]);
		return $id;
	}
}
