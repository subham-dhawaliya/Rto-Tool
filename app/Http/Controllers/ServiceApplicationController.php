<?php

namespace App\Http\Controllers;

use App\Models\ServiceApplication;
use App\Models\Document;
use App\Models\ApplicationStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ServiceApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceApplication::where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        $applications = $query->latest()->paginate(10);
        return view('applications.index', compact('applications'));
    }

    public function create($serviceType)
    {
        $viewMap = [
            'driving-license' => 'applications.driving-license',
            'learning-license' => 'applications.learning-license',
            'vehicle-registration' => 'applications.vehicle-registration',
        ];

        $view = $viewMap[$serviceType] ?? 'applications.create';
        return view($view, compact('serviceType'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_type' => 'required|string',
            'aadhaar_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'address_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:512',
            'signature' => 'nullable|file|mimes:jpg,jpeg,png|max:512',
            'medical_cert' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'll_copy' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'age_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'id_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sale_invoice' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'insurance_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'puc_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'form_20' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Create application
            $application = ServiceApplication::create([
                'user_id' => auth()->id(),
                'application_number' => 'RTO' . date('Y') . strtoupper(Str::random(8)),
                'service_type' => $validated['service_type'],
                'status' => 'pending',
                'data' => $request->except([
                    '_token', 'service_type', 
                    'declaration', 'declaration_info', 'declaration_documents', 'declaration_terms', 'declaration_penalty',
                    'aadhaar_doc', 'address_proof', 'photo', 'signature',
                    'medical_cert', 'll_copy', 'age_proof', 'id_proof',
                    'sale_invoice', 'insurance_doc', 'puc_doc', 'form_20'
                ]),
            ]);

            // Handle document uploads
            $documentTypes = [
                'aadhaar_doc', 'address_proof', 'photo', 'signature',
                'medical_cert', 'll_copy', 'age_proof', 'id_proof',
                'sale_invoice', 'insurance_doc', 'puc_doc', 'form_20'
            ];

            foreach ($documentTypes as $docType) {
                if ($request->hasFile($docType)) {
                    $file = $request->file($docType);
                    $path = $file->store('documents/' . $application->id, 'public');
                    
                    Document::create([
                        'service_application_id' => $application->id,
                        'document_type' => $docType,
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'status' => 'pending',
                    ]);
                }
            }

            // Create initial status history
            ApplicationStatusHistory::create([
                'service_application_id' => $application->id,
                'status' => 'pending',
                'remarks' => 'Application submitted successfully',
                'updated_by' => 'System',
            ]);

            DB::commit();

            return redirect()->route('applications.show', $application)
                ->with('success', 'Application submitted successfully! Your application number is: ' . $application->application_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to submit application. Please try again.')->withInput();
        }
    }

    public function show(ServiceApplication $application)
    {
        abort_if($application->user_id !== auth()->id(), 403);
        $application->load(['documents', 'statusHistory']);
        return view('applications.show', compact('application'));
    }

    public function edit(ServiceApplication $application)
    {
        abort_if($application->user_id !== auth()->id(), 403);
        abort_if($application->status !== 'pending', 403, 'Cannot edit application after processing has started.');
        
        $serviceType = $application->service_type;
        $viewMap = [
            'driving-license' => 'applications.driving-license',
            'learning-license' => 'applications.learning-license',
            'vehicle-registration' => 'applications.vehicle-registration',
        ];

        $view = $viewMap[$serviceType] ?? 'applications.create';
        return view($view, compact('application', 'serviceType'));
    }

    public function track(Request $request)
    {
        $application = null;
        
        if ($request->filled('application_number')) {
            $application = ServiceApplication::with(['documents', 'statusHistory'])
                ->where('application_number', $request->application_number)
                ->first();
        }

        return view('applications.track', compact('application'));
    }
}
