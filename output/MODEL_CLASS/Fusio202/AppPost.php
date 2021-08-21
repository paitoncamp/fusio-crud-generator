<?php

/**
 * This file is auto-generated.
 */

namespace App\Model\Fusio202;

/**
 * Description of AppPost class from entity App_Post.
 */
class AppPost implements JsonSerializable
{
	/** @var string|null */
	protected $tenantId;

	/** @var int */
	protected $id;

	/** @var int|null */
	protected $refId;

	/** @var int|null */
	protected $userId;

	/** @var string */
	protected $title;

	/** @var string */
	protected $summary;

	/** @var string */
	protected $content;

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
	 * @param int|null $refId
	 */
	public function setRefId(?int $refId): void
	{
		$this->refId=$refId;
	}


	/**
	 * @return int|null
	 */
	public function getRefId(): ?int
	{
		return $this->refId;
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
	 * @param string $summary
	 */
	public function setSummary(?string $summary): void
	{
		$this->summary=$summary;
	}


	/**
	 * @return string
	 */
	public function getSummary(): ?string
	{
		return $this->summary;
	}


	/**
	 * @param string $content
	 */
	public function setContent(?string $content): void
	{
		$this->content=$content;
	}


	/**
	 * @return string
	 */
	public function getContent(): ?string
	{
		return $this->content;
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
		'refId'=>$this->refId,
		'userId'=>$this->userId,
		'title'=>$this->title,
		'summary'=>$this->summary,
		'content'=>$this->content,
		'insertDate'=>$this->insertDate,
		static function($value):bool{
		return $value!==null;
		});
	}
}
