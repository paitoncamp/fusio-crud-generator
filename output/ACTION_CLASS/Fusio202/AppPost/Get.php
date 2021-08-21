<?php

/**
 * This file is auto-generated.
 */

namespace App\Action\Fusio202\AppPost;

use App\Model\Message;
use App\Service\Fusio202\AppPost;
use App\Service\Tenancy\TenantMember;
use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;
use PSX\Http\Exception as StatusCode;
use PSX\Http\Exception\InternalServerErrorException;
use PSX\Http\Exception\StatusCodeException;

/**
 * Description of Get class from entity App_Post.
 */
class Get extends ActionAbstract
{
	const APP_NAME = 'app-Fusio202';

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
				App_Post.id,
				App_Post.ref_id,
				App_Post.user_id,
				App_Post.title,
				App_Post.summary,
				App_Post.content,
				App_Post.insert_date,
				FROM App_Post
				WHERE App_Post.id=:id";
		$parameters = ["id" => (int) $request->get("apppost_id")];
		$definition=$builder->doEntity($sql, $parameters, [
			'tenantId' => 'tenantId' ,
			'id' => $builder->fieldInteger('id'),
			'refId' => $builder->fieldInteger('ref_id'),
			'userId' => $builder->fieldInteger('user_id'),
			'title' => 'title',
			'insertDate' => $builder->fieldDateTime('insert_date'),
			'links'=>[
				'self'=>$builder->fieldReplace('/fusio202/apppost/{id}'),
			]
		]);
		return $this->response->build(200, [], $builder->build($definition));
	}
}
