<?php

class GroupController extends Controller{
	public function indexAction(){
		return View::make("group/index",["groups"=>Group::all()]);
	}
}