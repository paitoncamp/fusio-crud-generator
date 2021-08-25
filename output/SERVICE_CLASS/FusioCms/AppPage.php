<?php

/**
 * This file is auto-generated.
 */

namespace App\Service\FusioCms\AppPage;

use App\Model\FusioCms\AppPage as AppPageModel;
use App\Repository\FusioCms\AppPage as AppPageRepository;
use Doctrine\DBAL\Connection;
use Fusio\Engine\Connector;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\DispatchInterface;
use PSX\CloudEvents\Builder;
use PSX\Framework\Util\Uuid;
use PSX\Http\Exception as StatusCode;

/**
 * Description of AppPage class from entity app_page.
 */
class AppPage
{
	const APP_NAME = 'app-FusioCms';

	/** @var Repository\FusioCms\AppPage */
	private $repository;

	/** @var DispatcherInterface */
	private $dispatcher;

	/** @var Fusio\Engine\Connector */
	private $connector;


	public function __construct(
		AppPageRepository $repository,
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


	public function create(AppPageModel $appPage, ContextInterface $context, string $tenantId): int
	{
		$this->assertAppPage($appPage);
		if ($tenantId === null) {
			throw new StatusCode\BadRequestException('No TenantId provided');
		}
		$this->setupTenantConnection($tenantId);
		$id = $this->repository->insert(
			$appPage->getId(),
			$appPage->getParentId(),
			$appPage->getUserId(),
			$appPage->getStatus(),
			$appPage->getSort(),
			$appPage->getTitle(),
			$appPage->getData(),
			$appPage->getInsertDate(),
		);
		$row = $this->repository->findById($id);
		$this->dispatchEvent('FusioCms_AppPage_created', $row, $id);
		return $id;
	}


	public function update(int $id, AppPageModel $appPage, string $tenantId)
	{
		$this->assertAppPage($appPage);
		if ($tenantId === null) {
			throw new StatusCode\BadRequestException('No TenantId provided');
		}
		$this->setupTenantConnection($tenantId);
		$row = $this->repository->findById($id);
		if (empty($row)) {
			throw new StatusCode\NotFoundException('Provided '.$id.' does not exist');
		}
		$this->repository->update($id,
			$appPage->getParentId(),
			$appPage->getUserId(),
			$appPage->getStatus(),
			$appPage->getSort(),
			$appPage->getTitle(),
			$appPage->getData(),
			$appPage->getInsertDate(),
		);
		$row = $this->repository->findById($id);
		$this->dispatchEvent('FusioCms_AppPage_updated', $row, $id);
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
		$this->dispatchEvent('FusioCms_AppPage_deleted', $row, $id);
		return $id;
	}


	public function dispatchEvent(string $type, array $data, int $id)
	{
		$event = (new Builder())
		->withId(Uuid::pseudoRandom())
		->withSource('/FusioCms/AppPage/' . $id)
		->withType($type)
		->withDataContentType('application/json')
		->withData($data)
		->build();
		$this->dispatcher->dispatch($type, $event);
	}


	/**
	 * Need to customize to your needs and entity model
	 */
	public function assertAppPage(AppPageModel $appPage)
	{
		$id=$appPage->getId();
		if ($id === null) {
			throw new StatusCode\BadRequestException('No id provided');
		}
		$parentId=$appPage->getParentId();
		if ($parentId === null) {
			throw new StatusCode\BadRequestException('No parent_id provided');
		}
		$userId=$appPage->getUserId();
		if ($userId === null) {
			throw new StatusCode\BadRequestException('No user_id provided');
		}
		$status=$appPage->getStatus();
		if ($status === null) {
			throw new StatusCode\BadRequestException('No status provided');
		}
		$sort=$appPage->getSort();
		if ($sort === null) {
			throw new StatusCode\BadRequestException('No sort provided');
		}
		$title=$appPage->getTitle();
		if ($title === null) {
			throw new StatusCode\BadRequestException('No title provided');
		}
		$data=$appPage->getData();
		if ($data === null) {
			throw new StatusCode\BadRequestException('No data provided');
		}
		$insertDate=$appPage->getInsertDate();
		if ($insertDate === null) {
			throw new StatusCode\BadRequestException('No insert_date provided');
		}
	}
}
