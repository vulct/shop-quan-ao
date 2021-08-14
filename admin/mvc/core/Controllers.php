<?php 

class Controllers
{
	public function controller($controllers)
	{
		require_once("./mvc/controllers/".$controllers.".php");
		return new $controllers;
	}
	public function models($models)
	{
		require_once("./mvc/models/".$models.".php");
		return new $models;
	}
	public function views($views, $dataViews = [], $cssFile = [])
	{
		require_once("./mvc/views/".$views.".php");
	}

}

 ?>