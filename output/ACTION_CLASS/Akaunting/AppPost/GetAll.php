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
 * Description of GetAll class from entity App_Post.
 */
class GetAll extends ActionAbstract
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
		$startIndex = (int)\$request->get('startIndex');
		$startIndex = $startIndex <= 0 ? 0 : $startIndex;
		$condition  = $this->getCondition($request);
		$sql = "SELECT '$tenantId' as `tenantId`,
				App_Post.id,
				App_Post.ref_id,
				App_Post.user_id,
				App_Post.title,
				App_Post.summary,
				App_Post.content,
				App_Post.insert_date,
				FROM App_Post
				WHERE ".$condition->getExpression($connection->getDatabasePlatform())."
				ORDER BY App_Post.id ASC";
		$parameters = array_merge($condition->getValues(), ['startIndex' => $startIndex]);
		$definition = [
			'totalResults' => $builder->doValue('SELECT COUNT(*) AS cnt FROM App_Post', [],
			$builder->fieldInteger('cnt')),
			'startIndex' => $startIndex,
			'entries' => $builder->doCollection($sql, $parameters, [
			'tenantId' => 'tenantId' ,
			'id' => $builder->fieldInteger('id'),
			'refId' => $builder->fieldInteger('ref_id'),
			'userId' => $builder->fieldInteger('user_id'),
			'title' => 'title',
			'insertDate' => $builder->fieldDateTime('insert_date'),
			'links'=>[
				'self'=>$builder->fieldReplace('/akaunting/apppost/{id}'),
			]
		]);
		return $this->response->build(200, [], $builder->build($definition));
	}


	/**
	 * below, should you customize for your needs!
	 */
	private function getCondition(RequestInterface $request): Condition
	{
		$condition = new Condition();
		$ref = $request->get('id');
		if (!empty($ref)) {
			$condition->equals('apppost.id', (int) $ref);
		}
		$name = $request->get('name');
		if (!empty($name)) {
			$condition->like('apppost.name', '%' . $name . '%');
		}
		return $condition;
	}
}
