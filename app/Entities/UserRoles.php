<?php namespace App\Entities;
use asligresik\easyapi\Entities\BaseEntity;
/**
* Class UserRoles
* @OA\Schema(
*     title="UserRoles",
*     description="UserRoles"
* )
*
* @OA\Tag(
*     name="UserRoles",
*     description="Справочник с должностями сотрудников (пользователей)" 
* )
*/
class UserRoles extends BaseEntity
{
    	/**
	 * @OA\Property(
	 *     description="id",
	 *     title="id",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=11,
	 * )
	 *
	 */
	private $id;
	/**
	 * @OA\Property(
	 *     description="id_subdivisions",
	 *     title="id_subdivisions",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=10,
	 * )
	 *
	 */
	private $id_subdivisions;
	/**
	 * @OA\Property(
	 *     description="title",
	 *     title="title",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=255,
	 * )
	 *
	 */
	private $title;
	/**
	 * @OA\Property(
	 *     description="status",
	 *     title="status",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=1,
	 * )
	 *
	 */
	private $status;
}
/**
 *
 * @OA\RequestBody(
 *     request="UserRoles",
 *     description="UserRoles object that needs to be added",
 *     @OA\JsonContent(ref="#/components/schemas/UserRoles"),
 *     @OA\MediaType(
 *         mediaType="application/x-www-form-urlencoded",
 *         @OA\Schema(ref="#/components/schemas/UserRoles")
 *     ),
 *     @OA\MediaType(
 *         mediaType="application/xml",
 *         @OA\Schema(ref="#/components/schemas/UserRoles")
 *     )
 * )
 */
