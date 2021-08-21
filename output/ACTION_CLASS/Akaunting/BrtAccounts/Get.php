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
 * Description of Get class from entity brt_accounts.
 */
class Get extends ActionAbstract
{
	const APP_NAME = 'app-Akaunting';

	private $tenantMemberService;


	public function __construct(TenantMemberService $tenantMemberService)
	{
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
		$connection = $this->connector->getConnection(self::APP_NAME."-".$tenantId);
		$builder    = new Builder($connection);
		$sql = "SELECT '$tenantId' as `tenantId`,
				brt_accounts.id,
				brt_accounts.company_id,
				brt_accounts.name,
				brt_accounts.number,
				brt_accounts.currency_code,
				brt_accounts.opening_balance,
				brt_accounts.bank_name,
				brt_accounts.bank_phone,
				brt_accounts.bank_address,
				brt_accounts.enabled,
				brt_accounts.created_at,
				brt_accounts.updated_at,
				brt_accounts.deleted_at,
				FROM brt_accounts
				WHERE brt_accounts.id=:id";
		$parameters = ["id" => (int) $request->get("brtaccounts_id")];
		$definition=$builder->doEntity($sql, $parameters, [
			'tenantId' => 'tenantId' ,
			'id' => $builder->fieldInteger('id'),
			'companyId' => $builder->fieldInteger('company_id'),
			'name' => 'name',
			'number' => 'number',
			'currencyCode' => 'currency_code',
			'bankName' => 'bank_name',
			'bankPhone' => 'bank_phone',
			'createdAt' => $builder->fieldDateTime('created_at'),
			'updatedAt' => $builder->fieldDateTime('updated_at'),
			'deletedAt' => $builder->fieldDateTime('deleted_at'),
			'links'=>[
				'self'=>$builder->fieldReplace('/akaunting/brtaccounts/{id}'),
			]
		]);
		return $this->response->build(200, [], $builder->build($definition));
	}
}
