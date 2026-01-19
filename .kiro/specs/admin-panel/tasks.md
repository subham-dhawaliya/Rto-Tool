# Implementation Plan: Admin Panel

## Overview

This implementation plan breaks down the admin panel development into discrete, manageable tasks. Each task builds on previous work and includes testing to ensure correctness. The implementation follows Laravel best practices and maintains clean separation of concerns.

## Tasks

- [x] 1. Database Setup and Migrations
  - Create migration for users table role column
  - Create admin_remarks table migration
  - Create document_verifications table migration
  - Create activity_logs table migration
  - Run all migrations
  - _Requirements: 1.5, 7.1, 5.1, 12.1_

- [x] 2. Create Models and Relationships
  - [x] 2.1 Extend User model with admin methods
    - Add isAdmin() and isSuperAdmin() methods
    - Add activityLogs() and remarks() relationships
    - Update fillable array with role field
    - _Requirements: 1.5, 11.1_

  - [x] 2.2 Create AdminRemark model
    - Define fillable fields
    - Add application() and admin() relationships
    - Add isPublic() helper method
    - _Requirements: 7.2, 7.3_

  - [x] 2.3 Create DocumentVerification model
    - Define fillable fields and casts
    - Add document() and verifier() relationships
    - Add isVerified() and isRejected() helper methods
    - _Requirements: 5.1, 5.2, 5.3_

  - [x] 2.4 Create ActivityLog model
    - Define fillable fields and casts
    - Add admin() relationship
    - Add polymorphic target() relationship
    - _Requirements: 12.1, 12.2_

- [x] 3. Create Middleware for Access Control
  - [x] 3.1 Create AdminMiddleware
    - Check if user is authenticated
    - Verify user role is admin or super_admin
    - Return 403 if unauthorized
    - _Requirements: 1.4, 1.5_

  - [x] 3.2 Create SuperAdminMiddleware
    - Check if user is authenticated
    - Verify user role is super_admin
    - Return 403 if unauthorized
    - _Requirements: 11.6_

  - [x] 3.3 Register middleware in Kernel
    - Add middleware to $middlewareAliases
    - _Requirements: 1.4_

- [x] 4. Checkpoint - Ensure database and models are working
  - Ensure all tests pass, ask the user if questions arise.

- [x] 5. Create Admin Authentication
  - [x] 5.1 Create AdminAuthController
    - Add showLogin() method for admin login page
    - Add login() method with role validation
    - Add logout() method
    - Log admin login activity
    - _Requirements: 1.1, 1.2, 1.3, 1.4_

  - [x] 5.2 Create admin login view
    - Design admin-specific login page
    - Add email and password fields
    - Add "Admin Portal" branding
    - _Requirements: 1.1_

  - [x] 5.3 Add admin authentication routes
    - GET /admin/login
    - POST /admin/login
    - POST /admin/logout
    - _Requirements: 1.1, 1.2_

- [x] 6. Create Admin Dashboard
  - [x] 6.1 Create AdminDashboardController
    - Calculate application statistics by status
    - Calculate appointment statistics
    - Fetch recent applications (last 10)
    - Fetch pending appointments
    - _Requirements: 2.2, 2.3, 2.4, 2.5_

  - [x] 6.2 Create admin dashboard view
    - Display statistics cards
    - Show recent applications table
    - Show pending appointments table
    - Add navigation to other admin sections
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_

  - [x] 6.3 Add admin dashboard route
    - GET /admin/dashboard (protected by admin middleware)
    - _Requirements: 2.1_

- [x] 7. Checkpoint - Ensure admin auth and dashboard work
  - Ensure all tests pass, ask the user if questions arise.

- [x] 8. Create Application Management
  - [x] 8.1 Create AdminApplicationController index method
    - Fetch applications with pagination
    - Implement status filter
    - Implement service type filter
    - Implement search by application number or user name
    - _Requirements: 3.1, 3.2, 3.3, 3.4_

  - [x] 8.2 Create AdminApplicationController show method
    - Load application with all relationships
    - Load user details
    - Load documents with verification status
    - Load status history
    - Load admin remarks
    - _Requirements: 4.1, 4.2, 4.3, 4.4_

  - [x] 8.3 Create AdminApplicationController updateStatus method
    - Validate status and reason
    - Update application status in transaction
    - Create status history entry
    - Log activity
    - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5_

  - [x] 8.4 Create AdminApplicationController addRemark method
    - Validate remark and visibility
    - Create admin remark record
    - _Requirements: 7.1, 7.2, 7.3_

  - [x] 8.5 Create applications list view
    - Display applications table with filters
    - Add status badges
    - Add search box
    - Add pagination
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5_

  - [x] 8.6 Create application detail view
    - Display all application information
    - Show document list with preview
    - Show status history timeline
    - Show admin remarks section
    - Add status update form
    - Add remark addition form
    - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5, 6.6, 7.4, 7.5_

- [x] 9. Create Document Verification
  - [x] 9.1 Create AdminDocumentController
    - Add verify() method
    - Validate status and rejection reason
    - Create/update document verification record
    - Log activity
    - _Requirements: 5.2, 5.3, 5.4, 5.5_

  - [x] 9.2 Add document verification UI to application detail view
    - Add verify/reject buttons for each document
    - Add rejection reason modal
    - Show verification status badges
    - Show verifier name and timestamp
    - _Requirements: 5.1, 5.2, 5.3, 5.6_

- [x] 10. Checkpoint - Ensure application management works
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 11. Create Appointment Management
  - [x] 11.1 Create AdminAppointmentController index method
    - Fetch appointments with pagination
    - Implement status filter
    - Implement RTO office filter
    - Implement date range filter
    - _Requirements: 8.1, 8.2, 8.3, 8.4_

  - [x] 11.2 Create AdminAppointmentController show method
    - Load appointment with user details
    - Load appointment history
    - _Requirements: 8.6_

  - [x] 11.3 Create AdminAppointmentController updateStatus method
    - Validate status and reason
    - Update appointment status
    - Log activity
    - _Requirements: 9.1, 9.2, 9.3, 9.4, 9.5_

  - [x] 11.4 Create AdminAppointmentController reschedule method
    - Validate new date and time
    - Store old date/time in activity log
    - Update appointment with new date/time
    - Log activity
    - _Requirements: 10.1, 10.2, 10.3, 10.4, 10.5_

  - [x] 11.5 Create appointments list view
    - Display appointments table with filters
    - Add status badges
    - Add date range picker
    - Add pagination
    - _Requirements: 8.1, 8.2, 8.3, 8.4, 8.5_

  - [x] 11.6 Create appointment detail view
    - Display appointment information
    - Show user details
    - Add status update form
    - Add reschedule form
    - Show appointment history
    - _Requirements: 8.6, 9.6, 10.6_

- [x] 12. Add Admin Routes
  - Group all admin routes under /admin prefix
  - Apply admin middleware to all routes
  - Add routes for dashboard, applications, documents, appointments
  - _Requirements: All admin features_

- [x] 13. Create Admin Navigation Layout
  - Create admin layout with sidebar navigation
  - Add links to dashboard, applications, appointments
  - Add admin user info in header
  - Add logout button
  - _Requirements: 2.1, 3.1, 8.1_

- [x] 14. Checkpoint - Ensure all admin features work
  - Ensure all tests pass, ask the user if questions arise.

- [x] 15. Create Activity Logging Service
  - [x] 15.1 Create ActivityLogger helper class
    - Add static methods for common actions
    - Automatically capture IP address
    - Automatically capture admin ID
    - _Requirements: 12.1, 12.2_

  - [x] 15.2 Integrate activity logging in all admin actions
    - Log login/logout
    - Log status changes
    - Log document verifications
    - Log remarks
    - Log appointment updates
    - _Requirements: 12.2_

- [x] 16. Add Bulk Operations
  - [x] 16.1 Add bulk selection to applications list
    - Add checkboxes for each application
    - Add "Select All" checkbox
    - _Requirements: 13.1_

  - [x] 16.2 Create bulk status update functionality
    - Add bulk action dropdown
    - Validate bulk status update
    - Process in database transaction
    - Show success/failure count
    - _Requirements: 13.2, 13.3, 13.4_

- [x] 17. Create Seeder for Admin User
  - Create AdminUserSeeder
  - Add default super_admin user (email: admin@rto.gov.in, password: admin123)
  - Add default admin user for testing
  - _Requirements: 1.5, 11.1_

- [x] 18. Final Testing and Polish
  - Test complete application verification workflow
  - Test document verification with rejection
  - Test appointment rescheduling
  - Test bulk operations
  - Test activity logging
  - Verify all middleware protections work
  - Test responsive design on mobile

## Notes

- All admin routes are prefixed with `/admin`
- Admin middleware protects all admin routes
- Activity logging happens automatically for all admin actions
- Database transactions ensure data consistency
- All timestamps are recorded for audit trail
- Status changes maintain complete history
