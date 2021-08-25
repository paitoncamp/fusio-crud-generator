<?php

/**
 * This file is auto-generated.
 */

namespace App\Repository\Akaunting;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

/**
 * Description of BrtAccounts class from entity brt_accounts.
 */
class BrtAccounts
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
		`name`,
		`number`,
		`currency_code`,
		`opening_balance`,
		`bank_name`,
		`bank_phone`,
		`bank_address`,
		`enabled`,
		`created_at`,
		`updated_at`,
		`deleted_at`,
				FROM brt_accounts WHERE `id` = :id', [
		    'id' => $id,
		]);
	}


	public function insert(
		int $id,
		int $companyId,
		string $name,
		string $number,
		string $currencyCode,
		float $openingBalance,
		string $bankName,
		string $bankPhone,
		string $bankAddress,
		boolean $enabled,
		datetime $createdAt,
		datetime $updatedAt,
		datetime $deletedAt
	): int {
		$this->connection->insert('brt_accounts', [
		'id'=>$id,
		'company_id'=>$companyId,
		'name'=>$name,
		'number'=>$number,
		'currency_code'=>$currencyCode,
		'opening_balance'=>$openingBalance,
		'bank_name'=>$bankName,
		'bank_phone'=>$bankPhone,
		'bank_address'=>$bankAddress,
		'enabled'=>$enabled,
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
		string $name,
		string $number,
		string $currencyCode,
		float $openingBalance,
		string $bankName,
		string $bankPhone,
		string $bankAddress,
		boolean $enabled,
		datetime $createdAt,
		datetime $updatedAt,
		datetime $deletedAt
	): int {
		$this->connection->update('brt_accounts', [
		'id'=>$id,
		'company_id'=>$companyId,
		'name'=>$name,
		'number'=>$number,
		'currency_code'=>$currencyCode,
		'opening_balance'=>$openingBalance,
		'bank_name'=>$bankName,
		'bank_phone'=>$bankPhone,
		'bank_address'=>$bankAddress,
		'enabled'=>$enabled,
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
		$this->connection->delete('brt_accounts', [
		'id'=>$id
		]);
		return $id;
	}
}
