<?php
namespace App\Repositories;
use App\Ad;

class AdRepository
{
	private $model;
	public function __construct()
	{
		$this->model = new Ad();
	}
}
