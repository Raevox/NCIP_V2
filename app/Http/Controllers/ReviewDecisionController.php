<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CocApplication;

class ReviewDecisionController extends Controller
{
    public function update(Request $request, $id)
    {
        $application = CocApplication::findOrFail($id);

        // Save review decisions
        $application->index_status     = $request->index_status;
        $application->index_remarks    = $request->index_remarks;
        $application->genealogy_status = $request->genealogy_status;
        $application->genealogy_remarks= $request->genealogy_remarks;
        $application->documents_status = $request->documents_status;
        $application->documents_remarks= $request->documents_remarks;
        $application->classification   = $request->classification;

        $application->save();

        return redirect()->route('staff.review.show', $application->id)
                         ->with('success', 'Review decision saved!');
    }
}
