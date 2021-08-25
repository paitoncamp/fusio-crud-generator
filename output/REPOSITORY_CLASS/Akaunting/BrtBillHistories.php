<?php

/**
 * This file is auto-generated.
 */

namespace App\Repository\Akaunting;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

/**
 * Description of BrtBillHistories class from entity brt_bill_histories.
 */
class BrtBillHistories
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
		`company_id`,
		`bill_id`,
		`status`,
		`notify`,
		`description`,
		`created_at`,
		`updated_at`,
		`deleted_at`,
				FROM brt_bill_histories WHERE `id` = :id', [
		    'id' => $id,
		]);
	}


	public function insert(
		int $id,
		int $companyId,
		int $billId,
		string $status,
		boolean $notify,
		string $description,
		datetime $createdAt,
		datetime $updatedAt,
		datetime $deletedAt
	): int {
		$this->connection->insert('brt_bill_histories', [
		'id'=>$id,
		'company_id'=>$companyId,
		'bill_id'=>$billId,
		'status'=>$status,
		'notify'=>$notify,
		'description'=>$description,
		'created_at'=>$createdAt,
		'updated_at'=>$updatedAt,
		'deleted_at'=>$deletedAt,
		],[
		'id'=>$id
		]);
		return $id;
	}


	public function update(
		int $id,
		int $companyId,
		int $billId,
		string $status,
		boolean $notify,
		string $description,
		datetime $createdAt,
		datetime $updatedAt,
		datetime $deletedAt
	): int {
		$this->connection->update('brt_bill_histories', [
		'id'=>$id,
		'company_id'=>$companyId,
		'bill_id'=>$billId,
		'status'=>$status,
		'notify'=>$notify,
		'description'=>$description,
		'created_at'=>$createdAt,
		'updated_at'=>$updatedAt,
		'deleted_at'=>$deletedAt,
		],[
		'id'=>$id
		]);
		return $id;
	}


	public function delete(int $id): int
	{
		$this->connection->delete('brt_bill_histories', [
		'id'=>$id
		]);
		return $id;
	}
}
