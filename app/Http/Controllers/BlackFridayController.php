<?php
// app/Http/Controllers/BlackFridayController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlackFridayController extends Controller
{
    public function index()
    {
        return view('black-friday');
    }
}
