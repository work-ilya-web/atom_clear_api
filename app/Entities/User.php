<?php namespace App\Entities;
use asligresik\easyapi\Entities\BaseEntity;
/**
* Class User
* @OA\Schema(
*     title="User",
*     description="User"
* )
*
* @OA\Tag(
*     name="User",
*     description="Сотрудники"
* )
*/
class User extends BaseEntity
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
	 *     description="email",
	 *     title="email",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=128,
	 * )
	 *
	 */
	private $email;
	/**
	 * @OA\Property(
	 *     description="role",
	 *     title="role",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=11,
	 * )
	 *
	 */
	private $role;
	/**
	 * @OA\Property(
	 *     description="Должность сотрудника из /userRoles",
	 *     title="user_statuses_id",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=11,
	 * )
	 *
	 */
	private $user_statuses_id;
	/**
	 * @OA\Property(
	 *     description="user_statuses_comment",
	 *     title="user_statuses_comment",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=1000,
	 * )
	 *
	 */
	private $user_statuses_comment;
	/**
	 * @OA\Property(
	 *     description="surname",
	 *     title="surname",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=255,
	 * )
	 *
	 */
	private $surname;
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
	 *     description="patronymic",
	 *     title="patronymic",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=255,
	 * )
	 *
	 */
	private $patronymic;
	/**
	 * @OA\Property(
	 *     description="phone",
	 *     title="phone",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=255,
	 * )
	 *
	 */
	private $phone;
	/**
	 * @OA\Property(
	 *     description="passport_serial",
	 *     title="passport_serial",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=4,
	 * )
	 *
	 */
	private $passport_serial;
	/**
	 * @OA\Property(
	 *     description="passport_number",
	 *     title="passport_number",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=6,
	 * )
	 *
	 */
	private $passport_number;
	/**
	 * @OA\Property(
	 *     description="passport_subdivision",
	 *     title="passport_subdivision",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=7,
	 * )
	 *
	 */
	private $passport_subdivision;
	/**
	 * @OA\Property(
	 *     description="birthdate",
	 *     title="birthdate",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=11,
	 * )
	 *
	 */
	private $birthdate;
	/**
	 * @OA\Property(
	 *     description="passport_issued_by",
	 *     title="passport_issued_by",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * )
	 *
	 */
	private $passport_issued_by;
	/**
	 * @OA\Property(
	 *     description="passport_date_issue",
	 *     title="passport_date_issue",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=255,
	 * )
	 *
	 */
	private $passport_date_issue;
	/**
	 * @OA\Property(
	 *     description="employment_date",
	 *     title="employment_date",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=11,
	 * )
	 *
	 */
	private $employment_date;
	/**
	 * @OA\Property(
	 *     description="questionary",
	 *     title="questionary",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=255,
	 * )
	 *
	 */
	private $questionary;
	/**
	 * @OA\Property(
	 *     description="ID файла из /files c типом user_avatar",
	 *     title="photo",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=true,
	 * 	   maxLength=20,
	 * )
	 *
	 */
	private $photo;
	/**
	 * @OA\Property(
	 *     description="region",
	 *     title="region",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=1000,
	 * )
	 *
	 */
	private $region;
	/**
	 * @OA\Property(
	 *     description="city",
	 *     title="city",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=100,
	 * )
	 *
	 */
	private $city;
	/**
	 * @OA\Property(
	 *     description="street",
	 *     title="street",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=1000,
	 * )
	 *
	 */
	private $street;
	/**
	 * @OA\Property(
	 *     description="building",
	 *     title="building",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=1000,
	 * )
	 *
	 */
	private $building;
	/**
	 * @OA\Property(
	 *     description="apartment",
	 *     title="apartment",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=100,
	 * )
	 *
	 */
	private $apartment;
	/**
	 * @OA\Property(
	 *     description="registration_region",
	 *     title="registration_region",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=1000,
	 * )
	 *
	 */
	private $registration_region;
	/**
	 * @OA\Property(
	 *     description="registration_city",
	 *     title="registration_city",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=1000,
	 * )
	 *
	 */
	private $registration_city;
	/**
	 * @OA\Property(
	 *     description="registration_street",
	 *     title="registration_street",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=1000,
	 * )
	 *
	 */
	private $registration_street;
	/**
	 * @OA\Property(
	 *     description="registration_apartment",
	 *     title="registration_apartment",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=100,
	 * )
	 *
	 */
	private $registration_apartment;
	/**
	 * @OA\Property(
	 *     description="registration_building",
	 *     title="registration_building",
	 *     type="string",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=100,
	 * )
	 *
	 */
	private $registration_building;
	/**
	 * @OA\Property(
	 *     description="Скан паспорта",
	 *     title="img_passport",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * )
	 *
	 */
	private $img_passport;
	/**
	 * @OA\Property(
	 *     description="Скан снилс",
	 *     title="img_snils",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * )
	 *
	 */
	private $img_snils;
	/**
	 * @OA\Property(
	 *     description="Скан ИНН  ",
	 *     title="img_inn",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * )
	 *
	 */
	private $img_inn;
	/**
	 * @OA\Property(
	 *     description="ID подразделения  из /userSubdivisions",
	 *     title="user_subdivisions_id",
	 *     type="integer",
	 * 	   format="-",
	 * 	   nullable=false,
	 * 	   maxLength=11,
	 * )
	 *
	 */
	private $user_subdivisions_id;
}
/**
 *
 * @OA\RequestBody(
 *     request="User",
 *     description="User object that needs to be added",
 *     @OA\JsonContent(ref="#/components/schemas/User"),
 *     @OA\MediaType(
 *         mediaType="multipart/form-data",
 *         @OA\Schema(ref="#/components/schemas/User")
 *     ),
 *     @OA\MediaType(
 *         mediaType="application/x-www-form-urlencoded",
 *         @OA\Schema(ref="#/components/schemas/User")
 *     ),
 *     @OA\MediaType(
 *         mediaType="application/xml",
 *         @OA\Schema(ref="#/components/schemas/User")
 *     )
 * )
 */
