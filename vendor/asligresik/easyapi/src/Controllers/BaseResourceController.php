<?php
namespace asligresik\easyapi\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */


use CodeIgniter\RESTful\ResourceController;
use Config\Database;
class BaseResourceController extends ResourceController
{
	/**
	 * @license Apache 2.0
	 */

	/**
	 * @OA\Info(
	 *     description="This is a sample Opensid server.  You can find
out more about Swagger at
[http://swagger.io](http://swagger.io) or on
[irc.freenode.net, #swagger](http://swagger.io/irc/).",
	 *     version="1.0.0",
	 *     title="Swagger Opensid",
	 *     termsOfService="http://swagger.io/terms/",
	 *     @OA\Contact(
	 *         email="apiteam@swagger.io"
	 *     ),
	 *     @OA\License(
	 *         name="Apache 2.0",
	 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
	 *     )
	 * )
	 */
	/**
	 * @OA\Server(
	 *     description="SwaggerHUB API Mocking",
	 *     url="http://localhost:8080"
	 * )
	 */

	/**
	 * @OA\SecurityScheme(
	 *     type="http",
	 *     securityScheme="bearer_auth",
	 *     name="bearer_auth",
	 * 	   scheme="bearer",
	 * 	   bearerFormat="JWT"
	 * )
	 */

	/**
	 *
	 * @var string Name of the model class managing this resource's data
	 */
	protected $modelName;

	/**
	 *
	 * @var int limit data to show
	 */
	protected $limit = 10;


	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return array	an array
	 */
	protected $db;
	public function __construct()
	{
		$this->db = Database::connect();

	}
	public function index()
	{
		$search = (array)$this->request->getGet('search');
		$concat = (array)$this->request->getGet('concat');
		$order = $this->request->getGet('order');
		$page = $this->request->getGet('page') ?? 1;
		$limit = $this->request->getGet('limit') ?? $this->limit;
		$types = $this->model->typeFields;
		if ($limit > 0) {
			$total = $this->model->search($search,$order,$concat)->findAll();
			$data = $this->model->search($search,$order,$concat)->paginate($limit, 'default', $page);
			$sql = $this->model->getLastQuery()->getQuery();

			$this->writeLog();
			$pagination = [
				'currentPage' => $this->model->pager->getCurrentPage(),
				'totalPage' => $this->model->pager->getPageCount(),
				'total' => count($total),
			];
			if(!empty($types)){
				foreach ($data as  $row=>$item) {
					foreach ($item as $key => $field) {
						if(@$types[$key]=='int'){
							$data[$row][$key] = (int)$field;
						}
						if(@$types[$key]=='string'){
							$data[$row][$key] = (string)$field;
						}
						if(@$types[$key]=='bool'){
							$data[$row][$key] = (boolean)$field;
						}
					}
				}
			}

			return $this->respond(['data' => $data, 'pagination' => $pagination]);


		}

		if ($limit == -1) {
			$data = $this->model->search($search,$order,$concat)->findAll();
			if(!empty($types)){
				foreach ($data as  $row=>$item) {
					foreach ($item as $key => $field) {
						if(@$types[$key]=='int'){
							$data[$row][$key] = (int)$field;
						}
						if(@$types[$key]=='string'){
							$data[$row][$key] = (string)$field;
						}
						if(@$types[$key]=='bool'){
							$data[$row][$key] = (boolean)$field;
						}
					}
				}
			}
			$this->writeLog();
			return $this->respond(['data' => $data]);
		}

	}

	/**
	 * Return the properties of a resource object
	 *
	 * @return array	an array
	 */
	public function show($id = null)
	{

		$types = $this->model->typeFields;
		$record = $this->model->find_id($id);
		$this->writeLog();
		if (!$record) {
			return $this->failNotFound(sprintf(
				'item with id %d not found',
				$id
			));
		}
		if(!empty($types)){
			foreach ($record as $key => $field) {
				if(@$types[$key]=='int'){
					$record[$key] = (int)$field;
				}
				if(@$types[$key]=='string'){
					$record[$key] = (string)$field;
				}
				if(@$types[$key]=='bool'){
					$record[$key] = (boolean)$field;
				}
			}
		}
		return $this->respond($record);
	}

	/**
	 * Return a new resource object, with default properties
	 *
	 * @return array	an array
	 */
	public function new()
	{
		//return $this->fail(lang('RESTful.notImplemented', ['new']), 501);
	}

	/**
	 * Create a new resource object, from "posted" parameters
	 *
	 * @return array	an array
	 */
	public function create()
	{
		$data = $this->request->getJSON();
		if(empty($data)){
            $data = (object)$_POST;
        }

		if (!$this->model->insert($data)) {

			return $this->fail($this->model->errors(), 422);
		}
		$data->id = $this->model->insertID();
		$this->writeLog();
		return $this->respondCreated($data, 'product created');
	}

	/**
	 * Return the editable properties of a resource object
	 *
	 * @return array	an array
	 */
	public function edit($id = null)
	{
		return $this->show($id);
	}

	/**
	 * Add or update a model resource, from "posted" properties
	 *
	 * @return array	an array
	 */
	public function update($id = null)
	{

		$data       = $this->request->getJSON();
		if(empty($data)){
			$data = $this->request->getRawInput();
		}

		//$updateData = array_filter((array)$data);
		$updateData = (array)$data;
		$updateData[$this->model->primaryKey] = $id;
		if (!$this->model->save($updateData)) {
			return $this->fail($this->model->errors(), 422);
		}
		$this->writeLog();
		return $this->respond($data, 200, 'data updated');
	}

	/**
	 * Delete the designated resource object from the model
	 *
	 * @return array	an array
	 */
	public function delete($id = null)
	{
		$delete = $this->model->delete($id);
		if ($this->model->db->affectedRows() === 0) {
			return $this->failNotFound(sprintf(
				'item with id %d not found or already deleted',
				$id
			));
		}
        $this->writeLog();
		return $this->respondDeleted(['id' => $id], 'data deleted');
	}

	protected function writeLog(){
		if(ENVIRONMENT !== 'production'){
			$query = $this->db->getLastQuery();
      		log_message('critical', (string)$query);
		}
	}
}
