<?php namespace App\Repositories\Core;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\NotEntityDefined;


class BaseEloquentRepository implements RepositoryInterface
{
    protected $entity;
    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }
	public function getAll(){
		return $this->entity->all();
	}

	public function store($request){
		$this->entity->create($request);
	}


	public function edit($id){
		return $this->entity->find($id);
	}

	public function destroy($id){
		$this->entity->where('id', $id)->delete();
	}

    public function resolveEntity(){
        if(!method_exists($this, 'entity')){
            throw new NotEntityDefined();
        }
        return app($this->entity());
    }

}