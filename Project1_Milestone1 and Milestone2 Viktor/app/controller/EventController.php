<?php
// public event endpoints; nothing fancy yet
class EventController extends Controller {
  public function index(){ $this->view(); } // list
  public function show(){ $this->view(); }  // detail
}
