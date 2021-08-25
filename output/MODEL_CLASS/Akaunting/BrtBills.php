<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

namespace App\Model\Akaunting;

/**
 * Description of BrtBills class from entity brt_bills.
 */
class BrtBills implements JsonSerializable
{
	/** @var string|null */
	protected $tenantId;

	/** @var int */
	protected $id;

	/** @var int */
	protected $companyId;

	/** @var string */
	protected $billNumber;

	/** @var string|null */
	protected $orderNumber;

	/** @var string */
	protected $status;

	/** @var datetime */
	protected $billedAt;

	/** @var datetime */
	protected $dueAt;

	/** @var float */
	protected $amount;

	/** @var string */
	protected $currencyCode;

	/** @var float */
	protected $currencyRate;

	/** @var int */
	protected $categoryId;

	/** @var int */
	protected $contactId;

	/** @var string */
	protected $contactName;

	/** @var string|null */
	protected $contactEmail;

	/** @var string|null */
	protected $contactTaxNumber;

	/** @var string|null */
	protected $contactPhone;

	/** @var string|null */
	protected $contactAddress;

	/** @var string|null */
	protected $notes;

	/** @var int */
	protected $parentId;

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
	 * @param string $billNumber
	 */
	public function setBillNumber(?string $billNumber): void
	{
		$this->billNumber=$billNumber;
	}


	/**
	 * @return string
	 */
	public function getBillNumber(): ?string
	{
		return $this->billNumber;
	}


	/**
	 * @param string|null $orderNumber
	 */
	public function setOrderNumber(?string $orderNumber): void
	{
		$this->orderNumber=$orderNumber;
	}


	/**
	 * @return string|null
	 */
	public function getOrderNumber(): ?string
	{
		return $this->orderNumber;
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
	 * @param datetime $billedAt
	 */
	public function setBilledAt(?datetime $billedAt): void
	{
		$this->billedAt=$billedAt;
	}


	/**
	 * @return datetime
	 */
	public function getBilledAt(): ?datetime
	{
		return $this->billedAt;
	}


	/**
	 * @param datetime $dueAt
	 */
	public function setDueAt(?datetime $dueAt): void
	{
		$this->dueAt=$dueAt;
	}


	/**
	 * @return datetime
	 */
	public function getDueAt(): ?datetime
	{
		return $this->dueAt;
	}


	/**
	 * @param float $amount
	 */
	public function setAmount(?float $amount): void
	{
		$this->amount=$amount;
	}


	/**
	 * @return float
	 */
	public function getAmount(): ?float
	{
		return $this->amount;
	}


	/**
	 * @param string $currencyCode
	 */
	public function setCurrencyCode(?string $currencyCode): void
	{
		$this->currencyCode=$currencyCode;
	}


	/**
	 * @return string
	 */
	public function getCurrencyCode(): ?string
	{
		return $this->currencyCode;
	}


	/**
	 * @param float $currencyRate
	 */
	public function setCurrencyRate(?float $currencyRate): void
	{
		$this->currencyRate=$currencyRate;
	}


	/**
	 * @return float
	 */
	public function getCurrencyRate(): ?float
	{
		return $this->currencyRate;
	}


	/**
	 * @param int $categoryId
	 */
	public function setCategoryId(?int $categoryId): void
	{
		$this->categoryId=$categoryId;
	}


	/**
	 * @return int
	 */
	public function getCategoryId(): ?int
	{
		return $this->categoryId;
	}


	/**
	 * @param int $contactId
	 */
	public function setContactId(?int $contactId): void
	{
		$this->contactId=$contactId;
	}


	/**
	 * @return int
	 */
	public function getContactId(): ?int
	{
		return $this->contactId;
	}


	/**
	 * @param string $contactName
	 */
	public function setContactName(?string $contactName): void
	{
		$this->contactName=$contactName;
	}


	/**
	 * @return string
	 */
	public function getContactName(): ?string
	{
		return $this->contactName;
	}


	/**
	 * @param string|null $contactEmail
	 */
	public function setContactEmail(?string $contactEmail): void
	{
		$this->contactEmail=$contactEmail;
	}


	/**
	 * @return string|null
	 */
	public function getContactEmail(): ?string
	{
		return $this->contactEmail;
	}


	/**
	 * @param string|null $contactTaxNumber
	 */
	public function setContactTaxNumber(?string $contactTaxNumber): void
	{
		$this->contactTaxNumber=$contactTaxNumber;
	}


	/**
	 * @return string|null
	 */
	public function getContactTaxNumber(): ?string
	{
		return $this->contactTaxNumber;
	}


	/**
	 * @param string|null $contactPhone
	 */
	public function setContactPhone(?string $contactPhone): void
	{
		$this->contactPhone=$contactPhone;
	}


	/**
	 * @return string|null
	 */
	public function getContactPhone(): ?string
	{
		return $this->contactPhone;
	}


	/**
	 * @param string|null $contactAddress
	 */
	public function setContactAddress(?string $contactAddress): void
	{
		$this->contactAddress=$contactAddress;
	}


	/**
	 * @return string|null
	 */
	public function getContactAddress(): ?string
	{
		return $this->contactAddress;
	}


	/**
	 * @param string|null $notes
	 */
	public function setNotes(?string $notes): void
	{
		$this->notes=$notes;
	}


	/**
	 * @return string|null
	 */
	public function getNotes(): ?string
	{
		return $this->notes;
	}


	/**
	 * @param int $parentId
	 */
	public function setParentId(?int $parentId): void
	{
		$this->parentId=$parentId;
	}


	/**
	 * @return int
	 */
	public function getParentId(): ?int
	{
		return $this->parentId;
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
		'billNumber'=>$this->billNumber,
		'orderNumber'=>$this->orderNumber,
		'status'=>$this->status,
		'billedAt'=>$this->billedAt,
		'dueAt'=>$this->dueAt,
		'amount'=>$this->amount,
		'currencyCode'=>$this->currencyCode,
		'currencyRate'=>$this->currencyRate,
		'categoryId'=>$this->categoryId,
		'contactId'=>$this->contactId,
		'contactName'=>$this->contactName,
		'contactEmail'=>$this->contactEmail,
		'contactTaxNumber'=>$this->contactTaxNumber,
		'contactPhone'=>$this->contactPhone,
		'contactAddress'=>$this->contactAddress,
		'notes'=>$this->notes,
		'parentId'=>$this->parentId,
		'createdAt'=>$this->createdAt,
		'updatedAt'=>$this->updatedAt,
		'deletedAt'=>$this->deletedAt,
		static function($value):bool{
		return $value!==null;
		});
	}
}
