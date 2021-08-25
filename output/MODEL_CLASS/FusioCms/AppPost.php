<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

namespace App\Model\FusioCms;

/**
 * Description of AppPost class from entity app_post.
 */
class AppPost implements JsonSerializable
{
	/** @var string|null */
	protected $tenantId;

	/** @var int */
	protected $id;

	/** @var int|null */
	protected $pageId;

	/** @var int|null */
	protected $userId;

	/** @var int */
	protected $status;

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
	 * @param int|null $pageId
	 */
	public function setPageId(?int $pageId): void
	{
		$this->pageId=$pageId;
	}


	/**
	 * @return int|null
	 */
	public function getPageId(): ?int
	{
		return $this->pageId;
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
		'pageId'=>$this->pageId,
		'userId'=>$this->userId,
		'status'=>$this->status,
		'title'=>$this->title,
		'summary'=>$this->summary,
		'content'=>$this->content,
		'insertDate'=>$this->insertDate,
		static function($value):bool{
		return $value!==null;
		});
	}
}
