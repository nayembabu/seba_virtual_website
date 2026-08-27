<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class ManagerController extends Controller {
 public function dashboard() { return redirect()->route('admin.dashboard'); }
}
