<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

namespace App\Model\FusioCms;

/**
 * Description of AppPage class from entity app_page.
 */
class AppPage implements JsonSerializable
{
	/** @var string|null */
	protected $tenantId;

	/** @var int */
	protected $id;

	/** @var int|null */
	protected $parentId;

	/** @var int|null */
	protected $userId;

	/** @var int */
	protected $status;

	/** @var int */
	protected $sort;

	/** @var string */
	protected $title;

	/** @var json */
	protected $data;

	/** @var datetime */
	protected $insertDate;


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
	 * @param int|null $parentId
	 */
	public function setParentId(?int $parentId): void
	{
		$this->parentId=$parentId;
	}


	/**
	 * @return int|null
	 */
	public function getParentId(): ?int
	{
		return $this->parentId;
	}


	/**
	 * @param int|null $userId
	 */
	public function setUserId(?int $userId): void
	{
		$this->userId=$userId;
	}


	/**
	 * @return int|null
	 */
	public function getUserId(): ?int
	{
		return $this->userId;
	}


	/**
	 * @param int $status
	 */
	public function setStatus(?int $status): void
	{
		$this->status=$status;
	}


	/**
	 * @return int
	 */
	public function getStatus(): ?int
	{
		return $this->status;
	}


	/**
	 * @param int $sort
	 */
	public function setSort(?int $sort): void
	{
		$this->sort=$sort;
	}


	/**
	 * @return int
	 */
	public function getSort(): ?int
	{
		return $this->sort;
	}


	/**
	 * @param string $title
	 */
	public function setTitle(?string $title): void
	{
		$this->title=$title;
	}


	/**
	 * @return string
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}


	/**
	 * @param json $data
	 */
	public function setData(?json $data): void
	{
		$this->data=$data;
	}


	/**
	 * @return json
	 */
	public function getData(): ?json
	{
		return $this->data;
	}


	/**
	 * @param datetime $insertDate
	 */
	public function setInsertDate(?datetime $insertDate): void
	{
		$this->insertDate=$insertDate;
	}


	/**
	 * @return datetime
	 */
	public function getInsertDate(): ?datetime
	{
		return $this->insertDate;
	}


	public function jsonSerialize()
	{
		return (object) array_filter(array(
		'id'=>$this->id,
		'parentId'=>$this->parentId,
		'userId'=>$this->userId,
		'status'=>$this->status,
		'sort'=>$this->sort,
		'title'=>$this->title,
		'data'=>$this->data,
		'insertDate'=>$this->insertDate,
		static function($value):bool{
		return $value!==null;
		});
	}
}
