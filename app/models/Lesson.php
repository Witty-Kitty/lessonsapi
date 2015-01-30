<?php

class Lesson extends Eloquent {
	
	//protected $fillable = array('title', 'body');
	protected $fillable = ['title', 'body', 'some_bool']; 

	public function tags(){
		return $this->belongsToMany('Tag');
	}
}