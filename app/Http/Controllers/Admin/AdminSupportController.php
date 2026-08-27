<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class AdminSupportController extends Controller {
    public function index() { return view('admin.supports.index'); }
    public function show($id) { return view('admin.supports.show', compact('id')); }
    public function reply(Request $r, $id) { return back(); }
    public function markSolved($id) { return back(); }
    public function updateStatus(Request $r, $id) { return back(); }
}
