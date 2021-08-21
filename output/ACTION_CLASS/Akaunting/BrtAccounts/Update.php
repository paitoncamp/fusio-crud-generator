<?php

/**
 * This file is auto-generated.
 */

namespace App\Action\Akaunting\BrtAccounts;

use App\Model\Message;
use App\Service\Akaunting\BrtAccounts;
use App\Service\Tenancy\TenantMember;
use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;
use PSX\Http\Exception as StatusCode;
use PSX\Http\Exception\InternalServerErrorException;
use PSX\Http\Exception\StatusCodeException;

/**
 * Description of Update class from entity brt_accounts.
 */
class Update extends ActionAbstract
{
	private $brtAccountsService;
	private $tenantMemberService;


	public function __construct(BrtAccounts $brtAccountsService, TenantMemberService $tenantMemberService)
	{
		$this->brtAccountsService=$brtAccountsService;
		$this->tenantMemberService=$tenantMemberService;
	}


	public function handle(RequestInterface $request, ParametersInterface $configuration, ContextInterface $context)
	{
		$tenantId=$request->getHeader("tenantId");
		$currentUserId = $context->getUser()->getId();
		$checkUser = $this->tenantMemberService->checkCurrentUserIsTenant($currentUserId,$tenantId);;
		if(!$checkUser){
			throw new StatusCode\NotFoundException("Current user is not in current tenant!");
		}
		try {
			$id = $this->brtAccountsService->update(
				(int) $request->get("brtaccounts_id"),
				$request->getPayload(),
				$tenantId
			);
			$message = new Message();
			$message->setSuccess(true);
			$message->setMessage("brt_accountssuccessful created");
			$message->setId($id);
		} catch (StatusCodeException $e) {
			throw $e;
		} catch (\Throwable $e) {
			throw new InternalServerErrorException($e->getMessage());
		}
		return $this->response->build(201, [],$message);
	}
}
