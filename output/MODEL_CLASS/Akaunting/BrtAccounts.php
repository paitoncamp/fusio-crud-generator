<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

namespace App\Model\Akaunting;

/**
 * Description of BrtAccounts class from entity brt_accounts.
 */
class BrtAccounts implements JsonSerializable
{
	/** @var string|null */
	protected $tenantId;

	/** @var int */
	protected $id;

	/** @var int */
	protected $companyId;

	/** @var string */
	protected $name;

	/** @var string */
	protected $number;

	/** @var string */
	protected $currencyCode;

	/** @var float */
	protected $openingBalance;

	/** @var string|null */
	protected $bankName;

	/** @var string|null */
	protected $bankPhone;

	/** @var string|null */
	protected $bankAddress;

	/** @var boolean */
	protected $enabled;

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
	 * @param string $name
	 */
	public function setName(?string $name): void
	{
		$this->name=$name;
	}


	/**
	 * @return string
	 */
	public function getName(): ?string
	{
		return $this->name;
	}


	/**
	 * @param string $number
	 */
	public function setNumber(?string $number): void
	{
		$this->number=$number;
	}


	/**
	 * @return string
	 */
	public function getNumber(): ?string
	{
		return $this->number;
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
	 * @param float $openingBalance
	 */
	public function setOpeningBalance(?float $openingBalance): void
	{
		$this->openingBalance=$openingBalance;
	}


	/**
	 * @return float
	 */
	public function getOpeningBalance(): ?float
	{
		return $this->openingBalance;
	}


	/**
	 * @param string|null $bankName
	 */
	public function setBankName(?string $bankName): void
	{
		$this->bankName=$bankName;
	}


	/**
	 * @return string|null
	 */
	public function getBankName(): ?string
	{
		return $this->bankName;
	}


	/**
	 * @param string|null $bankPhone
	 */
	public function setBankPhone(?string $bankPhone): void
	{
		$this->bankPhone=$bankPhone;
	}


	/**
	 * @return string|null
	 */
	public function getBankPhone(): ?string
	{
		return $this->bankPhone;
	}


	/**
	 * @param string|null $bankAddress
	 */
	public function setBankAddress(?string $bankAddress): void
	{
		$this->bankAddress=$bankAddress;
	}


	/**
	 * @return string|null
	 */
	public function getBankAddress(): ?string
	{
		return $this->bankAddress;
	}


	/**
	 * @param boolean $enabled
	 */
	public function setEnabled(?boolean $enabled): void
	{
		$this->enabled=$enabled;
	}


	/**
	 * @return boolean
	 */
	public function getEnabled(): ?boolean
	{
		return $this->enabled;
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
		'name'=>$this->name,
		'number'=>$this->number,
		'currencyCode'=>$this->currencyCode,
		'openingBalance'=>$this->openingBalance,
		'bankName'=>$this->bankName,
		'bankPhone'=>$this->bankPhone,
		'bankAddress'=>$this->bankAddress,
		'enabled'=>$this->enabled,
		'createdAt'=>$this->createdAt,
		'updatedAt'=>$this->updatedAt,
		'deletedAt'=>$this->deletedAt,
		static function($value):bool{
		return $value!==null;
		});
	}
}
