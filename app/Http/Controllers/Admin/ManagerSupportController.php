<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class ManagerSupportController extends Controller {
 public function index() { return redirect()->route('admin.dashboard'); }
 public function show() { return redirect()->route('admin.dashboard'); }
}
