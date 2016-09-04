<?php

class ForumGroup extends Eloquent{

	protected $table = 'forum_groups';

	public function categories(){

		return $this->hasMany('ForumCategory', 'group_id');
	}

	public function Threads(){

		return $this->hasMany('ForumThread', 'group_id');
	}

	public function Comments(){

		return $this->hasMany('ForumComment', 'group_id');
	}
}