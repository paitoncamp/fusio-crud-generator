<?php

/**
 * This file is auto-generated.
 */

namespace App\Repository\Akaunting;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

/**
 * Description of BrtBills class from entity brt_bills.
 */
class BrtBills
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
		`bill_number`,
		`order_number`,
		`status`,
		`billed_at`,
		`due_at`,
		`amount`,
		`currency_code`,
		`currency_rate`,
		`category_id`,
		`contact_id`,
		`contact_name`,
		`contact_email`,
		`contact_tax_number`,
		`contact_phone`,
		`contact_address`,
		`notes`,
		`parent_id`,
		`created_at`,
		`updated_at`,
		`deleted_at`,
				FROM brt_bills WHERE `id` = :id', [
		    'id' => $id,
		]);
	}


	public function insert(
		int $id,
		int $companyId,
		string $billNumber,
		string $orderNumber,
		string $status,
		datetime $billedAt,
		datetime $dueAt,
		float $amount,
		string $currencyCode,
		float $currencyRate,
		int $categoryId,
		int $contactId,
		string $contactName,
		string $contactEmail,
		string $contactTaxNumber,
		string $contactPhone,
		string $contactAddress,
		string $notes,
		int $parentId,
		datetime $createdAt,
		datetime $updatedAt,
		datetime $deletedAt
	): int {
		$this->connection->insert('brt_bills', [
		'id'=>$id,
		'company_id'=>$companyId,
		'bill_number'=>$billNumber,
		'order_number'=>$orderNumber,
		'status'=>$status,
		'billed_at'=>$billedAt,
		'due_at'=>$dueAt,
		'amount'=>$amount,
		'currency_code'=>$currencyCode,
		'currency_rate'=>$currencyRate,
		'category_id'=>$categoryId,
		'contact_id'=>$contactId,
		'contact_name'=>$contactName,
		'contact_email'=>$contactEmail,
		'contact_tax_number'=>$contactTaxNumber,
		'contact_phone'=>$contactPhone,
		'contact_address'=>$contactAddress,
		'notes'=>$notes,
		'parent_id'=>$parentId,
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
		string $billNumber,
		string $orderNumber,
		string $status,
		datetime $billedAt,
		datetime $dueAt,
		float $amount,
		string $currencyCode,
		float $currencyRate,
		int $categoryId,
		int $contactId,
		string $contactName,
		string $contactEmail,
		string $contactTaxNumber,
		string $contactPhone,
		string $contactAddress,
		string $notes,
		int $parentId,
		datetime $createdAt,
		datetime $updatedAt,
		datetime $deletedAt
	): int {
		$this->connection->update('brt_bills', [
		'id'=>$id,
		'company_id'=>$companyId,
		'bill_number'=>$billNumber,
		'order_number'=>$orderNumber,
		'status'=>$status,
		'billed_at'=>$billedAt,
		'due_at'=>$dueAt,
		'amount'=>$amount,
		'currency_code'=>$currencyCode,
		'currency_rate'=>$currencyRate,
		'category_id'=>$categoryId,
		'contact_id'=>$contactId,
		'contact_name'=>$contactName,
		'contact_email'=>$contactEmail,
		'contact_tax_number'=>$contactTaxNumber,
		'contact_phone'=>$contactPhone,
		'contact_address'=>$contactAddress,
		'notes'=>$notes,
		'parent_id'=>$parentId,
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
		$this->connection->delete('brt_bills', [
		'id'=>$id
		]);
		return $id;
	}
}
