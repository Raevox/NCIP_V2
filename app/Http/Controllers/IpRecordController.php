<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IpRecord;
use App\Models\User;
use App\Models\IpAccount;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class IpRecordController extends Controller
{
    // -------------------- Listing IP Records --------------------
  // -------------------- Listing IP Records --------------------
public function index(Request $request)
{
    // AJAX search endpoint
    if ($request->ajax()) {
        return $this->ajaxSearch($request);
    }

    $query = IpRecord::query();

    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', '%' . $search . '%')
              ->orWhere('last_name', 'like', '%' . $search . '%')
              ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $search . '%'])
              ->orWhere('barangay', 'like', '%' . $search . '%')
              ->orWhere('municipality', 'like', '%' . $search . '%')
              ->orWhere('ip_group', 'like', '%' . $search . '%');
        });
    }

    // Municipality filter
    if ($request->filled('municipality') && $request->municipality !== '') {
        $query->where('municipality', $request->municipality);
    }

    // IP Group filter
    if ($request->filled('ip_group') && $request->ip_group !== '') {
        $query->where('ip_group', $request->ip_group);
    }

    // ✅ FIXED: Flexible Date filters - Month only, Year only, or Both
    if ($request->filled('month') && $request->month !== '' && $request->filled('year') && $request->year !== '') {
        // Both month and year selected
        $query->whereYear('census_date', $request->year)
              ->whereMonth('census_date', $request->month);
    } elseif ($request->filled('year') && $request->year !== '') {
        // Year only selected - show all months in that year
        $query->whereYear('census_date', $request->year);
    } elseif ($request->filled('month') && $request->month !== '') {
        // Month only selected - show that month in any year
        $query->whereMonth('census_date', $request->month);
    }

    $records = $query->orderBy('created_at', 'desc')->paginate(10);
    
    $municipalities = IpRecord::select('municipality')->distinct()->whereNotNull('municipality')->orderBy('municipality')->pluck('municipality');
    $ipGroups = IpRecord::select('ip_group')->distinct()->whereNotNull('ip_group')->orderBy('ip_group')->pluck('ip_group');

    // Get years for filter dropdown
    $years = IpRecord::selectRaw('YEAR(census_date) as year')
        ->distinct()
        ->whereNotNull('census_date')
        ->orderBy('year', 'desc')
        ->pluck('year');

    return view('admin.ip_records.index', compact('records', 'municipalities', 'ipGroups', 'years'));
}

// -------------------- AJAX Search --------------------
private function ajaxSearch(Request $request)
{
    try {
        $query = IpRecord::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%')
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $search . '%'])
                  ->orWhere('barangay', 'like', '%' . $search . '%')
                  ->orWhere('municipality', 'like', '%' . $search . '%')
                  ->orWhere('ip_group', 'like', '%' . $search . '%');
            });
        }

        // Municipality filter
        if ($request->filled('municipality') && $request->municipality !== '') {
            $query->where('municipality', $request->municipality);
        }

        // IP Group filter
        if ($request->filled('ip_group') && $request->ip_group !== '') {
            $query->where('ip_group', $request->ip_group);
        }

        // ✅ FIXED: Flexible Date filters for AJAX
        if ($request->filled('month') && $request->month !== '' && $request->filled('year') && $request->year !== '') {
            // Both month and year selected
            $query->whereYear('census_date', $request->year)
                  ->whereMonth('census_date', $request->month);
        } elseif ($request->filled('year') && $request->year !== '') {
            // Year only selected - show all months in that year
            $query->whereYear('census_date', $request->year);
        } elseif ($request->filled('month') && $request->month !== '') {
            // Month only selected - show that month in any year
            $query->whereMonth('census_date', $request->month);
        }

        $records = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.ip_records.partials.table', compact('records'))->render();
    } catch (\Exception $e) {
        \Log::error('AJAX Search Error: ' . $e->getMessage());
        return response()->json(['error' => 'Search failed'], 500);
    }
}

    // -------------------- Archive / Soft Delete --------------------
    public function archive($id)
    {
        $record = IpRecord::findOrFail($id);
        $record->delete(); // Soft delete

        return redirect()->route('admin.archive.ip_records')
            ->with('success', 'IP Record archived successfully.');
    }

    // -------------------- Restore Archived Record --------------------
    public function restore($id)
    {
        $record = IpRecord::onlyTrashed()->findOrFail($id);
        $record->restore();

        return redirect()->route('admin.archive.ip_records')
            ->with('success', 'IP Record restored successfully.');
    }

    // -------------------- View All Archived Records --------------------
    public function archivedRecords()
    {
        $records = IpRecord::onlyTrashed()->paginate(10);
        $staffAdminAccounts = User::onlyTrashed()
                                  ->whereIn('role', ['admin','staff'])
                                  ->paginate(10, ['*'], 'staffAdminPage');
        $ipAccounts = IpAccount::onlyTrashed()->paginate(10, ['*'], 'ipPage');

        return view('admin.accounts.archive', compact('records', 'staffAdminAccounts', 'ipAccounts'));
    }

    // -------------------- CRUD Methods --------------------
    public function create()
    {
        return view('admin.ip_records.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRecord($request);

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $validated['image'] = $request->file('image')->storeAs('uploads/images', $filename, 'public');
        }

        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        IpRecord::create($validated);

        return redirect()->route('ip_records.index')->with('success', 'IP Record added successfully.');
    }

    public function edit($id)
    {
        $record = IpRecord::findOrFail($id);
        return view('admin.ip_records.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = IpRecord::findOrFail($id);
        $validated = $this->validateRecord($request, $record->id);

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $validated['image'] = $request->file('image')->storeAs('uploads/images', $filename, 'public');
        }

        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        $record->update($validated);

        return redirect()->route('ip_records.index')->with('success', 'IP Record updated successfully.');
    }

    public function destroy($id)
    {
        $record = IpRecord::findOrFail($id);
        $record->delete(); // Soft delete

        return redirect()->route('ip_records.index')->with('success', 'IP Record moved to archive.');
    }

    // -------------------- Download CSV --------------------
   public function download(Request $request)
{
    $query = IpRecord::query();

    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', '%' . $search . '%')
              ->orWhere('last_name', 'like', '%' . $search . '%')
              ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $search . '%']);
        });
    }

    // Municipality filter
    if ($request->filled('municipality') && $request->municipality !== '') {
        $query->where('municipality', $request->municipality);
    }

    // IP Group filter
    if ($request->filled('ip_group') && $request->ip_group !== '') {
        $query->where('ip_group', $request->ip_group);
    }

    // ✅ FIXED: Flexible Date filters for download
    if ($request->filled('month') && $request->month !== '' && $request->filled('year') && $request->year !== '') {
        // Both month and year selected
        $query->whereYear('census_date', $request->year)
              ->whereMonth('census_date', $request->month);
    } elseif ($request->filled('year') && $request->year !== '') {
        // Year only selected - show all months in that year
        $query->whereYear('census_date', $request->year);
    } elseif ($request->filled('month') && $request->month !== '') {
        // Month only selected - show that month in any year
        $query->whereMonth('census_date', $request->month);
    }

    $records = $query->orderBy('created_at', 'desc')->get();

    $filename = "ip_records_export_" . date('Y-m-d') . ".csv";
    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $callback = function () use ($records) {
        $file = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fwrite($file, "\xEF\xBB\xBF");
        
        fputcsv($file, [
            'First Name', 'Last Name', 'Sex', 'IP Group',
            'Birth Date', 'Origin Province', 'Origin Municipality', 'Origin Barangay',
            'Province', 'Municipality', 'Barangay', 'Census Date',
            'Civil Status', 'Religion', 'NCIP Number', 'Occupation',
            'Income', 'PWD', 'Educational Level', 'Degree'
        ]);

        foreach ($records as $row) {
            fputcsv($file, [
                $row->first_name,
                $row->last_name,
                $row->sex,
                $row->ip_group,
                $row->birth_date ? $row->birth_date->format('Y-m-d') : '',
                $row->origin_province,
                $row->origin_municipality,
                $row->origin_barangay,
                $row->province,
                $row->municipality,
                $row->barangay,
                $row->census_date ? $row->census_date->format('Y-m-d') : '',
                $row->civil_status,
                $row->religion,
                $row->ncip_number,
                $row->occupation,
                $row->income,
                $row->pwd,
                $row->educational_level,
                $row->degree
            ]);
        }

        fclose($file);
    };

    return Response::stream($callback, 200, $headers);
}

    public function transaction($id)
    {
        $record = IpRecord::findOrFail($id);
        return view('admin.ip_records.transaction', compact('record'));
    }

    public function show($id)
    {
        $record = IpRecord::findOrFail($id);
        return view('admin.ip_records.show', compact('record'));
    }

    // -------------------- CERTIFICATE METHODS --------------------
    public function showCertificate($id)
    {
        $record = IpRecord::findOrFail($id);
        return view('admin.ip_records.certificate', compact('record'));
    }
    
    public function printCertificate($id)
    {
        $record = IpRecord::findOrFail($id);
        
        $pdf = Pdf::loadView('admin.ip_records.certificate_pdf', compact('record'));
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'COC-' . $record->first_name . '-' . $record->last_name . '-' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    // -------------------- Validation Helper --------------------
    private function validateRecord(Request $request, $id = null)
    {
        return $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|string|max:10',
            'ip_group' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'origin_province' => 'nullable|string|max:100',
            'origin_municipality' => 'nullable|string|max:100',
            'origin_barangay' => 'nullable|string|max:100',
            'census_date' => 'required|date',
            'province' => 'required|string|max:100',
            'municipality' => 'required|string|max:100',
            'barangay' => 'required|string|max:100',
            'civil_status' => 'required|string|max:50',
            'religion' => 'required|string|max:100',
            'ncip_number' => 'required|string|max:100',
            'occupation' => 'required|string|max:100',
            'income' => 'nullable|string|max:100',
            'pwd' => 'nullable|string|max:100',
            'educational_level' => 'required|string|max:50',
            'degree' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    }

    public function formCertificate($id, Request $request)
    {
        $record = IpRecord::findOrFail($id);
        
        $pdf = Pdf::loadView('admin.ip_records.coc_template', compact('record'));
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename with COC number format
        $cocNumber = 'COC-R03-NUE-' . date('m-y', strtotime($record->created_at)) . '-' . str_pad($record->id, 4, '0', STR_PAD_LEFT);
        $filename = $cocNumber . '.pdf';
        
        // Check if download is requested
        if ($request->get('download') == '1') {
            return $pdf->download($filename);
        }
        
        // Default: stream for preview
        return $pdf->stream($filename);
    }
}
