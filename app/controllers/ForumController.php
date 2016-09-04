<?php

class ForumController extends BaseController{

	public function index(){

		
			$groups = ForumGroup::all();
			$categories = ForumCategory::all();
			$latestPost = ForumThread::orderBy('created_at','desc')->take(10)->get();


			return View::make('forum.index')
				->with('groups', $groups)
				->with('categories', $categories)
				->with('latestPost', $latestPost);

		}
	public function search() {


		$q = Input::get('keyword');
		if (!empty($q)) {
		$searchTerms = explode(' ', $q);

		$query = DB::table('forum_threads');


			foreach ($searchTerms as $term) {
			$query->where('body', 'LIKE', '%' . $term . '%')
				  ->orWhere('title', 'LIKE', '%'. $term .'%')->distinct();

			}

			$results = $query->get();

			return View::make('forum.search')
				->with('results', $results);
		} 

		else {
			

		return Redirect::route('forum-home')->with('fail', "Please search with keywords!");


			
		}

	}

	public function category($id){

		$category = ForumCategory::find($id);
		if ($category == null){

			return Redirect::route('forum-home')->with('fail', "That category does not exist!");
		}
		$threads = $category->threads()->get();
		return View::make('forum.category')->with('category', $category)->with('threads', $threads);
		
	}

	public function thread($id){

		$thread = ForumThread::find($id);

		if($thread == null){

			return Redirect::route('forum-home')->with('fail', "That thread does not exist!");
		}

		else{

			$author = $thread->author()->first()->username;

			return View::make('forum.thread')->with('thread', $thread)->with('author', $author);
		}
		
	}
		public function showeditThread($id){

		$thread = ForumThread::find($id);

		if($thread == null){

			return Redirect::back()->with('fail', "That thread does not exist!");
		}

		else{

			return View::make('forum.editthread')->with('thread', $thread);
		}
		
	}

	public function storeGroup(){		

		$validator = Validator::make(Input::all(), array(
			'group_name' => 'required|unique:forum_groups,title'
			 ));
		if ($validator->fails()){

			return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('modal','#group_form');
		}
		
		else{

			$group = new ForumGroup;
			$group->title = Input::get('group_name');
			$group->author_id = Auth::user()->id;

			if($group->save()){

				return Redirect::route('forum-home')->with('success', 'The Group is created');
			}
			else{
				return Redirect::route('forum-home')->with('fail', 'An error occured');
			}
		}
	}

	public function deleteGroup($id){

		$group = ForumGroup::find($id);

		if($group == null){

			return Redirect::route('forum-home')->with('fail', 'That Group Does not exist!');
		}
		

			$catagories = $group->categories();
			$threads = $group->threads();
			$comments = $group->comments();
		

		$delCa = true;
		$delT = true;
		$delCo = true;

		if($catagories->count() > 0){

			$delCa = $catagories->delete();
		}

		if($threads->count() > 0){

			$delT = $threads->delete();
		}
		if($comments->count() > 0){

			$delCo = $comments->delete();
		}
		if($delCa && $delT && $delCo && $group->delete()){

			return Redirect::route('forum-home')->with('success', 'The group is deleted.');
		}
		else{

			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting.');
		}
	}


	public function deleteCategory($id){

		$category = ForumCategory::find($id);

		if($category == null){

			return Redirect::route('forum-home')->with('fail', 'That Category Does not exist!');
		}
		

			$threads = $category->threads();
			$comments = $category->comments();
		

		$delT = true;
		$delCo = true;

		if($threads->count() > 0){

			$delT = $threads->delete();
		}
		if($comments->count() > 0){

			$delCo = $comments->delete();
		}
		if($delT && $delCo && $category->delete()){

			return Redirect::route('forum-home')->with('success', 'The category is deleted.');
		}
		else{

			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting.');
		}
	}

	public function storeCategory($id){

		$validator = Validator::make(Input::all(), array(
			'category_name' => 'required|unique:forum_categories,title'
			 ));
		if ($validator->fails()){

			return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('category-modal','#category_modal')->with('group_id', $id);
		}
		
		else{

			$group = ForumGroup::find($id);

			if($group == null){

			return Redirect::route('forum-home')->with('fail', 'That Group Does not exist!');
		}

			$category = new ForumCategory;
			$category->title = Input::get('category_name');
			$category->author_id = Auth::user()->id;
			$category->group_id = $id;

			if($category->save()){

				return Redirect::route('forum-home')->with('success', 'The Category is created');
			}
			else{
				return Redirect::route('forum-home')->with('fail', 'An error occured');
			}
		}
	}

	public function newThread($id){

		return View::make('forum.newthread')->with('id', $id);
	}	

	public function storeThread($id){

		$category = ForumCategory::find($id);

		if ($category == null)
			Redirect::route('forum-get-new-thread')->with('fail', 'You posted invalid category!');
		$validator = Validator::make(Input::all(), array(

			'title' => 'required|min:3|max:255',
			'body'	=> 'required|min:10|max:66000'

			));
			
			if ($validator->fails()){

				return Redirect::route('forum-get-new-thread', $id)->withInput()->withErrors($validator)->with('fail', 'Input does not match minimum requirment!');

				}
			else{

				$thread = new ForumThread;
				$thread->title = Input::get('title');				
				$thread->body = Input::get('body');
				$thread->category_id = $id;
				$thread->group_id = $category->group_id;
				$thread->author_id = Auth::user()->id;

				if($thread->save()){

					return Redirect::route('forum-thread', $thread->id)->with('success', 'Thread has been saved!');

				}
				else{

					return Redirect::route('forum-get-new-thread', $id)->with('fail', 'An error occured while saving Thread!')->withInput();
				}
			}

		}
		
		public function editThread($id){

		$thread = ForumThread::find($id);

		if ($thread == null)
			Redirect::back()->with('fail', 'An error occured!');
		$validator = Validator::make(Input::all(), array(

			'title' => 'required|min:3|max:255',
			'body'	=> 'required|min:10|max:66000'

			));
			
			if ($validator->fails()){

				return Redirect::back()->withInput()->withErrors($validator)->with('fail', 'Input does not match minimum requirment!');

				}
			else{

				$thread->title = Input::get('title');				
				$thread->body = Input::get('body');
			
				if($thread->save()){

					return Redirect::route('forum-thread', $thread->id)->with('success', 'Thread has been updated!');

				}
				else{

					return Redirect::back()->with('fail', 'An error occured while updating Thread!')->withInput();
				}
			}

		}

		public function deleteThread($id){

			$thread = ForumThread::find($id);
			if($thread == null)
				return Redirect::route('forum-home')->with('fail', 'That thread Does not exist!');

			$category_id = $thread->category_id;
			$comments = $thread->comments;
			if($comments->count() > 0){

				if($comments->delete() && $thread->delete())
					return Redirect::route('forum-category', $category_id)->with('success', 'The thread is deleted successfully!');
				
				else{
					return Redirect::route('forum-category', $category_id)->with('fail', 'An error occured while deleting thread!');
					}
			}
			else{

				if($thread->delete())
					return Redirect::route('forum-category', $category_id)->with('success', 'The thread is deleted successfully!');
				
				else{
					return Redirect::route('forum-category', $category_id)->with('fail', 'An error occured while deleting thread!');
					}
				}

		}

		public function storeComment($id){

		$Response   = array(
            'success' => '0',
            'error' => 'Your Flash Message'
        );

		$thread = ForumThread::find($id);

			if($thread == null)
				return Redirect::route('forum-home')->with('fail', 'That thread Does not exist!');

			$validator = Validator::make(Input::all(), array(

				'body'	=> 'required|min:5'

			));



			if ($validator->fails()){

				return Redirect::route('forum-thread', $id)->withInput()->withErrors($validator)->with('fail', 'Input of comments does not match minimum requirment!');

				}
			else { 

				$comment = new ForumComment();
				$comment->body = Input::get('body');
				$comment->author_id = Auth::user()->id;
				$comment->thread_id = $id;
				$comment->category_id = $thread->category->id;
				$comment->group_id = $thread->group->id;
			
				if($comment->save()){
		            return Response::json(array( 'body' => $comment->body, 'tagMessage' => "Akhane kisu dibi" ));
		        }else{
		            return Response::json(array('status' => 'FAIL'));
		        }

			//	if($comment->save()){

					
					//return Redirect::route('forum-thread', $id)->with('success', 'Comment has been saved.');

			//	}
//else{


					//return Redirect::route('forum-thread', $id)->with('fail', 'An error occured while saving Comment!');
//}
			}
		}
		
		public function showComment($id){
			
			$comment = ForumComment::find($id);
			
			return  View::make('forum.editcomment')->with('comment', $comment);
		}
		
		public function editComment($id){
			
			$comment = ForumComment::find($id);
				if($comment == null)
				return Redirect::back()->with('fail', 'That comment Does not exist!');

			$validator = Validator::make(Input::all(), array(

				'body'	=> 'required|min:5'

			));

			if ($validator->fails()){

				return Redirect::back()->withInput()->withErrors($validator)->with('fail', 'Input of comments does not match minimum requirment!');

				}
			else { 

				$comment->body = Input::get('body');

				if($comment->save()){
		            return Redirect::back()->with('success', 'Comment has been edited.');
		        }else{
		            return Redirect::route('forum-thread', $id)->with('fail', 'An error occured while editing Comment!');
		        	 }
				}
			
		}

		public function deleteComment($id){

			$comment = ForumComment::find($id);
			if($comment == null)

				return Redirect::route('forum-thread')->with('fail', 'That comment Does not exist!');
			$threadid = $comment->thread->id;

			$comment = ForumComment::find($id);
			if($comment->delete())

				return Redirect::route('forum-thread', $threadid)->with('success', 'That comment has been deleted');
			else{

					return Redirect::route('forum-thread', $threadid)->with('fail', 'An error occured while deleting Comment!');
				}

		}
}