<?php

class ForumThread extends Eloquent{
	
	protected $fillable = ['title', 'body'];

	protected $table = 'forum_threads';

	public function group(){

		return $this->belongsto('ForumGroup');
	}

	public function category(){

		return $this->belongsto('ForumCategory');
	}

	public function Comments(){

		return $this->hasMany('ForumComment', 'thread_id');
	}

	public function author(){

		return $this->belongsto('User', 'author_id');
	}
}