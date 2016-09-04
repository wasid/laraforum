<?php

class ForumComment extends Eloquent{
	
	protected $fillable = ['body'];

	protected $table = 'forum_comments';

	public function group(){

		return $this->belongsto('ForumGroup');
	}

	public function Category(){

		return $this->belongsto('ForumCategory');
	}

	public function Thread(){

		return $this->belongsto('ForumThread');
	}

	public function author(){

		return $this->belongsto('User', 'author_id');
	}
} 