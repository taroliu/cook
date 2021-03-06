<?php
include ("app/forms/BaseForm.php");
include ("app/forms/GroupForm.php");

class GroupController extends Controller {

	public function indexAction() {
		return View::make ( "group/index", [ 
				"groups" => Group::all () 
		] );
	}

	public function addAction() {
		$form = new GroupForm ();
		
		if ($form->isPosted ()) {
			if ($form->isValidForAdd ()) {
				Group::create ( [ 
						"name" => Input::get ( "name" ) 
				] );
				return Redirect::route ( "group/index" );
			}
			
			return Route::route ( "group/add" )->withInput ( [ 
					"name" => Input::get ( "name" ),
					"errors" => $form->getErrors () 
			] );
		}
		
		return View::make ( "group/add", [ 
				"form" => $form 
		] );
	}

	public function editAction() {
		$form = new GroupForm ();
		/*
		 * We do this with Eloquent��s findOrFail() method; which will cause a 404 error page to be displayed if the id is not found within the database .
		 */
		$group = Group::findOrFail ( Input::get ( "id" ) );
		$url = URL::full ();
		
		if ($form->isPosted ()) {
			if ($form->isValidForEdit ()) {
				$group->name = Input::get ( "name" );
				$group->save ();
				return Redirect::route ( "group/index" );
			}
			
			return Redirect::to ( $url )->withInput ( [ 
					"name" => Input::get ( "name" ),
					"errors" => $form->getErrors (),
					"url" => $url 
			] );
		}
		
		return View::make ( "group/edit", [ 
				"form" => $form,
				"group" => $group 
		] );
	}

	public function deleteAction() {
		$form = new GroupForm ();
		
		if ($form->isValidForDelete ()) {
			$group = Group::findOrFail ( Input::get ( "id" ) );
			$group->delete ();
		}
		
		return Redirect::route ( "group/index" );
	}

}