<?php namespace App\Entities;
use asligresik\easyapi\Entities\BaseEntity;
/**
* Class Files
* @OA\Schema(
*     title="Files",
*     description="Files"
* )
*
* @OA\Tag( 
*     name="Files",
*     description="Файлы"
* )
*/
class Files extends BaseEntity
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
	 *     description="name",
	 *     title="name",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=255,
	 * )
	 *
	 */
	private $name;
	/**
	 * @OA\Property(
	 *     description="type",
	 *     title="type",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=10,
	 * )
	 *
	 */
	private $type;
	/**
	 * @OA\Property(
	 *     description="size",
	 *     title="size",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=255,
	 * )
	 *
	 */
	private $size;
	/**
	 * @OA\Property(
	 *     description="user_id",
	 *     title="user_id",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=11,
	 * )
	 *
	 */
	private $user_id;
	/**
	 * @OA\Property(
	 *     description="date_create",
	 *     title="date_create",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=11,
	 * )
	 *
	 */
	private $date_create;
	/**
	 * @OA\Property(
	 *     description="path",
	 *     title="path",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=1000,
	 * )
	 *
	 */
	private $path;
}
/**
 *
 * @OA\RequestBody(
 *     request="Files",
 *     description="Files object that needs to be added",
 *     @OA\JsonContent(ref="#/components/schemas/Files"),
 *     @OA\MediaType(
 *         mediaType="application/x-www-form-urlencoded",
 *         @OA\Schema(ref="#/components/schemas/Files")
 *     ),
 *     @OA\MediaType(
 *         mediaType="application/xml",
 *         @OA\Schema(ref="#/components/schemas/Files")
 *     )
 * )
 */
