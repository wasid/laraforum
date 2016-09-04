<?php

class ForumCategory extends Eloquent{

	protected $table = 'forum_categories';

	public function group(){

		return $this->belongsto('ForumGroup');
	}

	public function Threads(){

		return $this->hasMany('ForumThread', 'category_id');
	}

	public function Comments(){

		return $this->hasMany('ForumComment', 'category_id');
	}
}