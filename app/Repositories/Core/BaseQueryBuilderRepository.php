<?php 

namespace App\Repositories\Core;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\PropertyTableNotExists;
use DB;


class BaseQueryBuilderRepository implements RepositoryInterface
{
    protected $tb;
    public function __construct()
    {
        $this->tb = $this->resolveTable();
    }
    public function getAll(){
		
	}

	public function store($request){
		
	}


	public function edit($id){
		
	}

	public function destroy($id){
		
	}

    public function resolveTable(){
       if (!property_exists($this, 'table')) {
           throw new PropertyTableNotExists();
       }

       return $this->table;

    }
}