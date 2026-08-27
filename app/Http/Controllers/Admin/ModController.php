<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class ModController extends Controller {
 public function index() { return redirect()->route('admin.dashboard'); }
 public function logout() { auth()->guard('admin')->logout(); return redirect('/'); }
 public function profile() { return view('admin.profile'); }
 public function profileUpdate() { return back(); }
}
