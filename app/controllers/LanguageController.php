<?php

Class LanguageController extends BaseController {
    public function select(){
			$lang = Input::get('lang');
			Session::put('local', $lang);
			//App::setLocale(Session::get('lang', $lang));
			return Redirect::to('/');
    }
}
