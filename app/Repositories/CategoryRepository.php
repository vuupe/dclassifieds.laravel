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
	
	public function getOneLevel($_parent_id = null)
	{
		return $this->model->getOneLevel($_parent_id);
	}
	
	public function getIdBySlug($_slug)
	{
		return $this->model->getIdBySlug($_slug);
	}
	
	public function getSlugById($_category_id)
	{
		return $this->model->getSlugById($_category_id);
	}
	
	public function getParentsBySlug($_slug)
	{
		return $this->model->getParentsBySlug($_slug);
	}
	
	public function getParentsById($_category_id)
	{
		return $this->model->getParentsById($_category_id);
	}
	
	public function getParentsBySlugFlat($_slug)
	{
		return $this->model->getParentsBySlugFlat($_slug);
	}
	
	public function getParentsByIdFlat($_category_id)
	{
		return $this->model->getParentsByIdFlat($_category_id);
	}
	
	public function getInfoBySlug($_slug)
	{
		return $this->model->getInfoBySlug($_slug);
	}
	
	public function getInfoById($_category_id)
	{
		return $this->model->getInfoById($_category_id);
	}
}