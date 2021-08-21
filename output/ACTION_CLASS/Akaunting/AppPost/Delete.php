<?php

/**
 * This file is auto-generated.
 */

namespace App\Action\Akaunting\AppPost;

use App\Model\Message;
use App\Service\Akaunting\AppPost;
use App\Service\Tenancy\TenantMember;
use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;
use PSX\Http\Exception as StatusCode;
use PSX\Http\Exception\InternalServerErrorException;
use PSX\Http\Exception\StatusCodeException;

/**
 * Description of Delete class from entity App_Post.
 */
class Delete extends ActionAbstract
{
	private $appPostService;
	private $tenantMemberService;


	public function __construct(AppPost $appPostService, TenantMemberService $tenantMemberService)
	{
		$this->appPostService=$appPostService;
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
			$id = $this->appPostService->delete(
				(int) $request->get("apppost_id"),
				$tenantId
			);
			$message = new Message();
			$message->setSuccess(true);
			$message->setMessage("App_Postsuccessful created");
			$message->setId($id);
		} catch (StatusCodeException $e) {
			throw $e;
		} catch (\Throwable $e) {
			throw new InternalServerErrorException($e->getMessage());
		}
		return $this->response->build(201, [],$message);
	}
}
