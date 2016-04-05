<?php

class BaseController extends Controller {

    public $user = null;
   
    
    public function __construct() {
        if (Sentry::check()) {
            $this->user = Sentry::getUser();
           
        }
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}
