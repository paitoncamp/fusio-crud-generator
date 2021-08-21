<?php

/**
 * This file is auto-generated.
 */

namespace App\Service\Fusio202\AppPost;

use App\Model\Fusio202\AppPost as AppPostModel;
use App\Repository\Fusio202\AppPost as AppPostRepository;
use Doctrine\DBAL\Connection;
use Fusio\Engine\Connector;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\DispatchInterface;
use PSX\CloudEvents\Builder;
use PSX\Framework\Util\Uuid;
use PSX\Http\Exception as StatusCode;

/**
 * Description of AppPost class from entity App_Post.
 */
class AppPost
{
	const APP_NAME = 'app-Fusio202';

	/** @var Repository\Fusio202\AppPost */
	private $repository;

	/** @var DispatcherInterface */
	private $dispatcher;

	/** @var Fusio\Engine\Connector */
	private $connector;


	public function __construct(
		AppPostRepository $repository,
		DispatcherInterface $dispatcher,
		ConnectorInterface $connector
	) {
		$this->repository=$repository;
		$this->dispatcher=$dispatcher;
		$this->connector=$connector;
	}


	public function setupTenantConnection($tenantId)
	{
		if (empty($tenantId)) {
		throw new StatusCode\NotFoundException('Provided request does not include with tenantId!');
		}
		$this->repository->setupConnection($this->connector->getConnection(self::APP_NAME.'-'.$tenantId));
	}


	public function create(AppPostModel $appPost, ContextInterface $context, string $tenantId): int
	{
		$this->assertAppPost($appPost);
		if ($tenantId === null) {
		throw new StatusCode\BadRequestException('No TenantId provided');
		}
		$this->setupTenantConnection($tenantId);
		$id = $this->repository->insert(
		$appPost->getId(),
		$appPost->getRefId(),
		$appPost->getUserId(),
		$appPost->getTitle(),
		$appPost->getSummary(),
		$appPost->getContent(),
		$appPost->getInsertDate(),
		);
		$row = $this->repository->findById($id);
		$this->dispatchEvent('Fusio202_AppPost_created', $row, $id);
		return $id;
	}


	public function update(int $id, AppPostModel $appPost, string $tenantId)
	{
		$this->assertAppPost($appPost);
		if ($tenantId === null) {
		throw new StatusCode\BadRequestException('No TenantId provided');
		}
		$this->setupTenantConnection($tenantId);
		$row = $this->repository->findById($id);
		if (empty($row)) {
		throw new StatusCode\NotFoundException('Provided '.$id.' does not exist');
		}
		$this->repository->update($id,
		$appPost->getRefId(),
		$appPost->getUserId(),
		$appPost->getTitle(),
		$appPost->getSummary(),
		$appPost->getContent(),
		$appPost->getInsertDate(),
		);
		$row = $this->repository->findById($id);
		$this->dispatchEvent('Fusio202_AppPost_updated', $row, $id);
		return $id;
	}


	public function delete(int $id, string $tenantId)
	{
		if ($tenantId === null) {
		throw new StatusCode\BadRequestException('No TenantId provided');
		}
		$this->setupTenantConnection($tenantId);
		$row = $this->repository->findById($id);
		if (empty($row)) {
		throw new StatusCode\NotFoundException('Provided '.$id.' does not exist');
		}
		$this->repository->delete($id);
		$this->dispatchEvent('Fusio202_AppPost_deleted', $row, $id);
		return $id;
	}


	public function dispatchEvent(string $type, array $data, int $id)
	{
		$event = (new Builder())
		->withId(Uuid::pseudoRandom())
		->withSource('/Fusio202/AppPost/' . $id)
		->withType($type)
		->withDataContentType('application/json')
		->withData($data)
		->build();
		$this->dispatcher->dispatch($type, $event);
	}


	/**
	 * Need to customize to your needs and entity model
	 */
	public function assertAppPost(AppPostModel $appPost)
	{
		$id=$appPost->getId();
		if ($id === null) {
			throw new StatusCode\BadRequestException('No id provided');
		}
		$refId=$appPost->getRefId();
		if ($refId === null) {
			throw new StatusCode\BadRequestException('No ref_id provided');
		}
		$userId=$appPost->getUserId();
		if ($userId === null) {
			throw new StatusCode\BadRequestException('No user_id provided');
		}
		$title=$appPost->getTitle();
		if ($title === null) {
			throw new StatusCode\BadRequestException('No title provided');
		}
		$summary=$appPost->getSummary();
		if ($summary === null) {
			throw new StatusCode\BadRequestException('No summary provided');
		}
		$content=$appPost->getContent();
		if ($content === null) {
			throw new StatusCode\BadRequestException('No content provided');
		}
		$insertDate=$appPost->getInsertDate();
		if ($insertDate === null) {
			throw new StatusCode\BadRequestException('No insert_date provided');
		}
	}
}
