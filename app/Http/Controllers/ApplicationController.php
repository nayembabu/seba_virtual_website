<?php

// ApplicationController.php (Controller)
namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function makePending($id)
    {
        $application = Application::findOrFail($id);

        // Update the status to "Pending" (assuming 'status' is a column in your database)
        $application->status = '0';
        $application->vendor_id = NULL;
        $application->save();

        return redirect()->back()->with('success', 'Application marked as Pending.');
    }
    
    
}
