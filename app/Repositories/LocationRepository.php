<?php
namespace App\Repositories;
use App\Location;

class LocationRepository
{
	private $model;
	public function __construct()
	{
		$this->model = new Location();
	}
	
	public function getAllHierarhy($_parent_id = null, $_level = 0)
	{
		return $this->model->getAllHierarhy($_parent_id, $_level);
	}
	
	public function getOneLevel($_parent_id = null)
	{
		return $this->model->getOneLevel($_parent_id);
	}
}