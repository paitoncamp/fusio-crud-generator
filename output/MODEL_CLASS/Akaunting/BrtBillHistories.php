<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

namespace App\Model\Akaunting;

/**
 * Description of BrtBillHistories class from entity brt_bill_histories.
 */
class BrtBillHistories implements JsonSerializable
{
	/** @var string|null */
	protected $tenantId;

	/** @var int */
	protected $id;

	/** @var int */
	protected $companyId;

	/** @var int */
	protected $billId;

	/** @var string */
	protected $status;

	/** @var boolean */
	protected $notify;

	/** @var string|null */
	protected $description;

	/** @var datetime|null */
	protected $createdAt;

	/** @var datetime|null */
	protected $updatedAt;

	/** @var datetime|null */
	protected $deletedAt;


	/**
	 * @param string|null $tenantId
	 */
	public function setTenantId(?string $tenantId): void
	{
		$this->tenantId=$tenantId;
	}


	/**
	 * @return string|null
	 */
	public function getTenantId(): ?string
	{
		return $this->tenantId;
	}


	/**
	 * @param int $id
	 */
	public function setId(?int $id): void
	{
		$this->id=$id;
	}


	/**
	 * @return int
	 */
	public function getId(): ?int
	{
		return $this->id;
	}


	/**
	 * @param int $companyId
	 */
	public function setCompanyId(?int $companyId): void
	{
		$this->companyId=$companyId;
	}


	/**
	 * @return int
	 */
	public function getCompanyId(): ?int
	{
		return $this->companyId;
	}


	/**
	 * @param int $billId
	 */
	public function setBillId(?int $billId): void
	{
		$this->billId=$billId;
	}


	/**
	 * @return int
	 */
	public function getBillId(): ?int
	{
		return $this->billId;
	}


	/**
	 * @param string $status
	 */
	public function setStatus(?string $status): void
	{
		$this->status=$status;
	}


	/**
	 * @return string
	 */
	public function getStatus(): ?string
	{
		return $this->status;
	}


	/**
	 * @param boolean $notify
	 */
	public function setNotify(?boolean $notify): void
	{
		$this->notify=$notify;
	}


	/**
	 * @return boolean
	 */
	public function getNotify(): ?boolean
	{
		return $this->notify;
	}


	/**
	 * @param string|null $description
	 */
	public function setDescription(?string $description): void
	{
		$this->description=$description;
	}


	/**
	 * @return string|null
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}


	/**
	 * @param datetime|null $createdAt
	 */
	public function setCreatedAt(?datetime $createdAt): void
	{
		$this->createdAt=$createdAt;
	}


	/**
	 * @return datetime|null
	 */
	public function getCreatedAt(): ?datetime
	{
		return $this->createdAt;
	}


	/**
	 * @param datetime|null $updatedAt
	 */
	public function setUpdatedAt(?datetime $updatedAt): void
	{
		$this->updatedAt=$updatedAt;
	}


	/**
	 * @return datetime|null
	 */
	public function getUpdatedAt(): ?datetime
	{
		return $this->updatedAt;
	}


	/**
	 * @param datetime|null $deletedAt
	 */
	public function setDeletedAt(?datetime $deletedAt): void
	{
		$this->deletedAt=$deletedAt;
	}


	/**
	 * @return datetime|null
	 */
	public function getDeletedAt(): ?datetime
	{
		return $this->deletedAt;
	}


	public function jsonSerialize()
	{
		return (object) array_filter(array(
		'id'=>$this->id,
		'companyId'=>$this->companyId,
		'billId'=>$this->billId,
		'status'=>$this->status,
		'notify'=>$this->notify,
		'description'=>$this->description,
		'createdAt'=>$this->createdAt,
		'updatedAt'=>$this->updatedAt,
		'deletedAt'=>$this->deletedAt,
		static function($value):bool{
		return $value!==null;
		});
	}
}
