# Design Document: Admin Panel

## Overview

The RTO Portal Admin Panel is a comprehensive administrative interface that enables RTO officials to manage user applications, verify documents, update statuses, manage appointments, and generate reports. The system follows Laravel's MVC architecture with role-based access control (RBAC) and maintains complete audit trails of all administrative actions.

The admin panel is built as a separate section of the application with its own authentication middleware, routes, and views. It provides a modern, responsive interface for efficient application processing and appointment management.

## Architecture

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────┐
│                    Admin Panel Layer                     │
├─────────────────────────────────────────────────────────┤
│  Admin Auth    │  Admin Dashboard  │  Admin Controllers │
│  Middleware    │  Views            │  (Applications,    │
│                │                   │   Appointments)    │
├─────────────────────────────────────────────────────────┤
│                   Business Logic Layer                   │
├─────────────────────────────────────────────────────────┤
│  Application   │  Document         │  Appointment       │
│  Service       │  Verification     │  Service           │
│                │  Service          │                    │
├─────────────────────────────────────────────────────────┤
│                      Data Layer                          │
├─────────────────────────────────────────────────────────┤
│  Users (Admin) │  Applications     │  Documents         │
│  Activity Logs │  Status History   │  Appointments      │
│  Admin Remarks │                   │                    │
└─────────────────────────────────────────────────────────┘
```

### Authentication Flow

```
Admin Login → Validate Credentials → Check Admin Role → Create Session → Redirect to Dashboard
     ↓              ↓                      ↓                    ↓                ↓
  Form Input    Database Query      Role Check          Session Store      Admin Panel
```

### Application Verification Flow

```
View Application → Review Details → Verify Documents → Add Remarks → Update Status → Notify User
       ↓               ↓                  ↓                ↓             ↓            ↓
  Load Data      Display Info      Mark Verified    Save Comment   Change State   Send Email
```

## Components and Interfaces

### 1. Database Schema Extensions

#### Users Table (Extended)
```php
Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['user', 'admin', 'super_admin'])->default('user');
    $table->boolean('is_active')->default(true);
    $table->timestamp('last_login_at')->nullable();
});
```

#### Admin Remarks Table
```php
Schema::create('admin_remarks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('application_id')->constrained()->onDelete('cascade');
    $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
    $table->text('remark');
    $table->enum('visibility', ['internal', 'public'])->default('public');
    $table->timestamps();
});
```

#### Document Verifications Table
```php
Schema::create('document_verifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('document_id')->constrained()->onDelete('cascade');
    $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
    $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
    $table->text('rejection_reason')->nullable();
    $table->timestamp('verified_at')->nullable();
    $table->timestamps();
});
```

#### Activity Logs Table
```php
Schema::create('activity_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
    $table->string('action_type'); // login, status_change, document_verify, etc.
    $table->string('target_type')->nullable(); // Application, Appointment, etc.
    $table->unsignedBigInteger('target_id')->nullable();
    $table->json('action_details')->nullable();
    $table->ipAddress('ip_address')->nullable();
    $table->timestamps();
});
```

### 2. Middleware

#### AdminMiddleware
```php
class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized access');
        }
        return $next($request);
    }
}
```

#### SuperAdminMiddleware
```php
class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized access');
        }
        return $next($request);
    }
}
```

### 3. Controllers

#### AdminDashboardController
```php
class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_applications' => ServiceApplication::count(),
            'pending_applications' => ServiceApplication::where('status', 'pending')->count(),
            'approved_applications' => ServiceApplication::where('status', 'approved')->count(),
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'confirmed')->count(),
        ];
        
        $recent_applications = ServiceApplication::with('user')
            ->latest()
            ->take(10)
            ->get();
            
        $pending_appointments = Appointment::with('user')
            ->where('status', 'confirmed')
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date')
            ->take(10)
            ->get();
            
        return view('admin.dashboard', compact('stats', 'recent_applications', 'pending_appointments'));
    }
}
```

#### AdminApplicationController
```php
class AdminApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceApplication::with('user', 'documents');
        
        // Apply filters
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('service_type')) {
            $query->where('service_type', $request->service_type);
        }
        
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('application_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $applications = $query->paginate(20);
        
        return view('admin.applications.index', compact('applications'));
    }
    
    public function show(ServiceApplication $application)
    {
        $application->load('user', 'documents.verification', 'statusHistory', 'remarks.admin');
        return view('admin.applications.show', compact('application'));
    }
    
    public function updateStatus(Request $request, ServiceApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected,on_hold,requires_clarification',
            'reason' => 'required_if:status,rejected,requires_clarification',
        ]);
        
        DB::transaction(function() use ($application, $validated) {
            // Update application status
            $application->update(['status' => $validated['status']]);
            
            // Create status history entry
            ApplicationStatusHistory::create([
                'application_id' => $application->id,
                'status' => $validated['status'],
                'changed_by' => auth()->id(),
                'remarks' => $validated['reason'] ?? null,
            ]);
            
            // Log activity
            ActivityLog::create([
                'admin_id' => auth()->id(),
                'action_type' => 'status_change',
                'target_type' => 'Application',
                'target_id' => $application->id,
                'action_details' => json_encode([
                    'new_status' => $validated['status'],
                    'reason' => $validated['reason'] ?? null,
                ]),
                'ip_address' => request()->ip(),
            ]);
        });
        
        return redirect()->back()->with('success', 'Application status updated successfully');
    }
    
    public function addRemark(Request $request, ServiceApplication $application)
    {
        $validated = $request->validate([
            'remark' => 'required|string|max:1000',
            'visibility' => 'required|in:internal,public',
        ]);
        
        AdminRemark::create([
            'application_id' => $application->id,
            'admin_id' => auth()->id(),
            'remark' => $validated['remark'],
            'visibility' => $validated['visibility'],
        ]);
        
        return redirect()->back()->with('success', 'Remark added successfully');
    }
}
```

#### AdminDocumentController
```php
class AdminDocumentController extends Controller
{
    public function verify(Request $request, Document $document)
    {
        $validated = $request->validate([
            'status' => 'required|in:verified,rejected',
            'rejection_reason' => 'required_if:status,rejected',
        ]);
        
        DB::transaction(function() use ($document, $validated) {
            DocumentVerification::updateOrCreate(
                ['document_id' => $document->id],
                [
                    'verified_by' => auth()->id(),
                    'status' => $validated['status'],
                    'rejection_reason' => $validated['rejection_reason'] ?? null,
                    'verified_at' => now(),
                ]
            );
            
            // Log activity
            ActivityLog::create([
                'admin_id' => auth()->id(),
                'action_type' => 'document_verify',
                'target_type' => 'Document',
                'target_id' => $document->id,
                'action_details' => json_encode([
                    'status' => $validated['status'],
                    'reason' => $validated['rejection_reason'] ?? null,
                ]),
                'ip_address' => request()->ip(),
            ]);
        });
        
        return redirect()->back()->with('success', 'Document verification updated');
    }
}
```

#### AdminAppointmentController
```php
class AdminAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with('user');
        
        // Apply filters
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('rto_office')) {
            $query->where('rto_office', $request->rto_office);
        }
        
        if ($request->has('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }
        
        $appointments = $query->orderBy('appointment_date')->paginate(20);
        
        return view('admin.appointments.index', compact('appointments'));
    }
    
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled,rescheduled,no_show',
            'reason' => 'required_if:status,cancelled',
        ]);
        
        $appointment->update([
            'status' => $validated['status'],
            'remarks' => $validated['reason'] ?? $appointment->remarks,
        ]);
        
        // Log activity
        ActivityLog::create([
            'admin_id' => auth()->id(),
            'action_type' => 'appointment_status_change',
            'target_type' => 'Appointment',
            'target_id' => $appointment->id,
            'action_details' => json_encode([
                'new_status' => $validated['status'],
                'reason' => $validated['reason'] ?? null,
            ]),
            'ip_address' => request()->ip(),
        ]);
        
        return redirect()->back()->with('success', 'Appointment status updated');
    }
    
    public function reschedule(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date|after:today',
            'time_slot' => 'required|string',
            'reason' => 'required|string',
        ]);
        
        $old_date = $appointment->appointment_date;
        $old_time = $appointment->time_slot;
        
        $appointment->update([
            'appointment_date' => $validated['appointment_date'],
            'time_slot' => $validated['time_slot'],
            'status' => 'rescheduled',
            'remarks' => $validated['reason'],
        ]);
        
        // Log activity
        ActivityLog::create([
            'admin_id' => auth()->id(),
            'action_type' => 'appointment_reschedule',
            'target_type' => 'Appointment',
            'target_id' => $appointment->id(),
            'action_details' => json_encode([
                'old_date' => $old_date,
                'old_time' => $old_time,
                'new_date' => $validated['appointment_date'],
                'new_time' => $validated['time_slot'],
                'reason' => $validated['reason'],
            ]),
            'ip_address' => request()->ip(),
        ]);
        
        return redirect()->back()->with('success', 'Appointment rescheduled successfully');
    }
}
```

### 4. Models

#### User Model (Extended)
```php
class User extends Authenticatable
{
    // ... existing code ...
    
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }
    
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }
    
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'admin_id');
    }
    
    public function remarks()
    {
        return $this->hasMany(AdminRemark::class, 'admin_id');
    }
}
```

#### AdminRemark Model
```php
class AdminRemark extends Model
{
    protected $fillable = ['application_id', 'admin_id', 'remark', 'visibility'];
    
    public function application()
    {
        return $this->belongsTo(ServiceApplication::class);
    }
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    
    public function isPublic(): bool
    {
        return $this->visibility === 'public';
    }
}
```

#### DocumentVerification Model
```php
class DocumentVerification extends Model
{
    protected $fillable = ['document_id', 'verified_by', 'status', 'rejection_reason', 'verified_at'];
    
    protected $casts = [
        'verified_at' => 'datetime',
    ];
    
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }
    
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
```

#### ActivityLog Model
```php
class ActivityLog extends Model
{
    protected $fillable = ['admin_id', 'action_type', 'target_type', 'target_id', 'action_details', 'ip_address'];
    
    protected $casts = [
        'action_details' => 'array',
    ];
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    
    public function target()
    {
        return $this->morphTo();
    }
}
```

## Data Models

### Application Status State Machine

```
pending → under_review → approved
   ↓           ↓            ↑
   ↓      on_hold ←────────┘
   ↓           ↓
   ↓    requires_clarification
   ↓           ↓
   └────→ rejected
```

### Appointment Status State Machine

```
confirmed → completed
    ↓           ↑
    ↓      rescheduled
    ↓           ↓
    └────→ cancelled
    └────→ no_show
```

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Admin Role Enforcement
*For any* user attempting to access admin routes, the system should only grant access if the user's role is 'admin' or 'super_admin'.
**Validates: Requirements 1.4, 1.5**

### Property 2: Status Transition Validity
*For any* application status update, the new status should be one of the valid statuses (pending, under_review, approved, rejected, on_hold, requires_clarification).
**Validates: Requirements 6.1**

### Property 3: Status History Completeness
*For any* application status change, a corresponding entry should be created in the application_status_history table with timestamp and admin identifier.
**Validates: Requirements 6.3, 6.6**

### Property 4: Document Verification Atomicity
*For any* document verification action, either all verification data (status, verifier, timestamp) should be saved together, or none should be saved.
**Validates: Requirements 5.5**

### Property 5: Rejection Reason Requirement
*For any* application status change to 'rejected' or 'requires_clarification', a non-empty reason must be provided.
**Validates: Requirements 6.5**

### Property 6: Activity Logging Completeness
*For any* admin action (status change, document verification, remark addition), a corresponding activity log entry should be created with action type, target, and timestamp.
**Validates: Requirements 12.1, 12.2**

### Property 7: Remark Visibility Constraint
*For any* admin remark, the visibility field should be either 'internal' or 'public', and internal remarks should not be visible to regular users.
**Validates: Requirements 7.6**

### Property 8: Appointment Reschedule History
*For any* appointment reschedule action, the system should preserve the old date/time in activity logs before updating to new date/time.
**Validates: Requirements 10.5, 10.6**

### Property 9: Super Admin Privilege Enforcement
*For any* admin user management action, only users with 'super_admin' role should be able to perform the action.
**Validates: Requirements 11.6**

### Property 10: Document Verification Status Consistency
*For any* document, if verification status is 'rejected', then rejection_reason field must be non-null.
**Validates: Requirements 5.4**

### Property 11: Bulk Operation Atomicity
*For any* bulk status update operation, either all selected applications should be updated successfully, or none should be updated (transaction rollback on error).
**Validates: Requirements 13.4**

### Property 12: Notification Creation on Application Submission
*For any* new application submission, a notification should be created for admin users.
**Validates: Requirements 14.1**

### Property 13: Dashboard Statistics Accuracy
*For any* dashboard load, the displayed statistics (total applications, pending count, etc.) should match the actual database counts.
**Validates: Requirements 2.2, 2.3**

### Property 14: Filter Result Consistency
*For any* application list filter (by status, service type, or search term), all returned results should match the filter criteria.
**Validates: Requirements 3.2, 3.3, 3.4**

### Property 15: Appointment Date Validation
*For any* appointment reschedule, the new appointment date should be in the future (after current date).
**Validates: Requirements 10.2**

## Error Handling

### Authentication Errors
- **Invalid Credentials**: Return 401 with error message "Invalid email or password"
- **Non-Admin Access**: Return 403 with error message "Unauthorized access to admin panel"
- **Session Expired**: Redirect to admin login with message "Session expired, please login again"

### Validation Errors
- **Missing Required Fields**: Return 422 with field-specific error messages
- **Invalid Status Transition**: Return 400 with error message "Invalid status transition"
- **Invalid Date Format**: Return 422 with error message "Invalid date format"

### Database Errors
- **Transaction Failure**: Rollback and return 500 with error message "Operation failed, please try again"
- **Foreign Key Constraint**: Return 400 with error message "Cannot perform operation due to related records"
- **Duplicate Entry**: Return 409 with error message "Record already exists"

### File Errors
- **Document Not Found**: Return 404 with error message "Document not found"
- **File Access Error**: Return 500 with error message "Unable to access document"

## Testing Strategy

### Unit Tests
- Test admin middleware role checking
- Test status transition validation
- Test remark visibility logic
- Test activity log creation
- Test bulk operation transaction handling

### Property-Based Tests
Each property-based test should run a minimum of 100 iterations to ensure comprehensive coverage through randomization.

- **Property 1 Test**: Generate random user roles and verify admin access control
  - **Feature: admin-panel, Property 1**: Admin Role Enforcement
  
- **Property 2 Test**: Generate random status values and verify only valid statuses are accepted
  - **Feature: admin-panel, Property 2**: Status Transition Validity
  
- **Property 3 Test**: Generate random status changes and verify history entries are created
  - **Feature: admin-panel, Property 3**: Status History Completeness
  
- **Property 5 Test**: Generate random status changes to rejected/requires_clarification and verify reason is required
  - **Feature: admin-panel, Property 5**: Rejection Reason Requirement
  
- **Property 6 Test**: Generate random admin actions and verify activity logs are created
  - **Feature: admin-panel, Property 6**: Activity Logging Completeness
  
- **Property 10 Test**: Generate random document verifications with rejected status and verify rejection_reason is non-null
  - **Feature: admin-panel, Property 10**: Document Verification Status Consistency
  
- **Property 13 Test**: Generate random application data and verify dashboard statistics match database counts
  - **Feature: admin-panel, Property 13**: Dashboard Statistics Accuracy
  
- **Property 14 Test**: Generate random filter criteria and verify all results match the criteria
  - **Feature: admin-panel, Property 14**: Filter Result Consistency
  
- **Property 15 Test**: Generate random appointment dates and verify rescheduled dates are in the future
  - **Feature: admin-panel, Property 15**: Appointment Date Validation

### Integration Tests
- Test complete application verification workflow
- Test document verification with status update
- Test appointment rescheduling with notification
- Test bulk operations with multiple applications
- Test admin login to dashboard navigation

### UI Tests
- Test admin login form submission
- Test application filtering and search
- Test document preview modal
- Test status update form
- Test remark addition form
