<?php
namespace App\Repositories;
use App\Category;

class CategoryRepository
{
	private $model;
	public function __construct()
	{
		$this->model = new Category();
	}
	
	public function getAllHierarhy($_parent_id = null, $_level = 0)
	{
		return $this->model->getAllHierarhy($_parent_id, $_level);
	}
}