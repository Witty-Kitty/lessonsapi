<?php namespace Acme\Transformers;

use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

abstract class Transformer{

	public function transformArray(array $items){

		return array_map([$this, 'transform'], $items);

	}

	public function transformCollection(Collection $collection){

		return $this->transformArray($collection->toArray());

	}

	public abstract function transform($item);

	public function transformPaginator(Paginator $paginator){

		return $this->transformArray($paginator->toArray()['data']);

	}

}