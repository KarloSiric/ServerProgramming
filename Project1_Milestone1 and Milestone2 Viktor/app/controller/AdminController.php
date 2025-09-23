<?php
// admin endpoints live here; every action is role-gated before rendering
class AdminController extends Controller {
  public function dashboard(){ $this->requireRole('admin'); $this->view(); } // hub
  public function events()   { $this->requireRole('admin'); $this->view(); } // table view
  public function eventedit(){ $this->requireRole('admin'); $this->view(); } // add/edit form
  public function venues()   { $this->requireRole('admin'); $this->view(); } // venues list
  public function users()    { $this->requireRole('admin'); $this->view(); } // users list
}
