<?php namespace App\Repositories\Contracts;

interface RepositoryInterface{
	
	public function getAll();

	public function store($request);

	public function edit($id);

	public function destroy($id);
}