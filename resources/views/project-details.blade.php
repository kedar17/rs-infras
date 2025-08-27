@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <!-- Milestone & Task Tracker -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0"><b>Milestone & Task Tracker</b></h1>

    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="accordion" id="milestoneAccordion">
                    <div class="accordion-item">
                        <div id="collapseOne" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    @foreach($tasks as $task)
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$task->title}}
                                        <span class="badge {{$task->status == 'Completed'? 'bg-success': 'bg-danger';}}">
                                            {{$task->status}}
                                        </span>
                                    </li>

                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Add more milestones here -->
                </div>
            </div>
        </div>


        <!-- Material Tracking -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Material Tracking</b></h1>

        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Material</th>
                                <th>Task</th>
                                <th>Requested</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materials as $material)
                            <tr>
                                <td>{{ $material->id }}</td>
                                <td>{{ $material->name }} ({{ $material->quantity }} - {{$material->unit}})</td>
                                <td> {{ optional($material->task)->title ?? '— No Task —' }}</td>
                                <td>{{ $material->request_date ?? '—' }}</td>
                                <td>{{ $material->status ?? '—' }}</td>

                                <td>
                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                            <!-- More material rows -->
                        </tbody>
                    </table>
                </div>
            </div>

            


        <!-- Expenditure  Tracking -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Expenditure & Budget Tracking</b></h1>
            <a href="#" data-bs-toggle="modal" data-bs-target="#addExpenseModal"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus text-white-50"></i> Add Expense
            </a>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Payment Reference</th>
                                <th>Remarks</th>
                                
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                        <tr>
                           
                            <td>{{ $expense->id }}</td>
                            <td>{{ $expense->updated_at ?? '—' }}</td>
                            <td>{{ $expense->category->name }}</td>
                            <td>{{ $expense->amount }}</td>
                            <td>{{ $expense->payment_mode }}</td>
                            <td>{{ $expense->payment_ref }}</td>
                            <td>{{ $expense->remarks }}</td>
                            
                            <td>
                                <button
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editexpenseModal-{{ $expense->id }}">
                                    Edit
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#alertModal-{{ $expense->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                            <!-- More rows dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Expense Modal -->
            <div class="modal fade" id="addExpenseModal" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Expense</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Item / Description</label>
                                <input type="text" class="form-control" placeholder="e.g., Bricks Purchase"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>Vendor / Supplier</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Amount (₹)</label>
                                <input type="number" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select class="form-select">
                                    <option>Materials</option>
                                    <option>Labor</option>
                                    <option>Transportation</option>
                                    <option>Equipment</option>
                                    <option>Miscellaneous</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select class="form-select">
                                    <option>Pending</option>
                                    <option>Approved</option>
                                    <option>Rejected</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Upload Bill (optional)</label>
                                <input type="file" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-success">Add Expense</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- Daily Work Log  Tracking -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Daily Work Log</b></h1>
            <a href="#" data-bs-toggle="modal" data-bs-target="#logEntryModal"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus text-white-50"></i> Add Work Log
            </a>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Logged By</th>
                                <th>Project Area</th>
                                <th>Work Summary</th>
                                <th>Weather</th>
                                <th>Photos</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2025-06-30</td>
                                <td>Rajesh (Site Supervisor)</td>
                                <td>Basement</td>
                                <td>Steel frame completed</td>
                                <td>Sunny</td>
                                <td><a href="#">View</a></td>
                                <td>None</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </td>
                            </tr>
                            <!-- More entries -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add   Modal -->
            <div class="modal fade" id="logEntryModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <form class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">New Work Log Entry</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row g-3 px-4">
                            <div class="col-md-6">
                                <label>Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Logged By</label>
                                <input type="text" class="form-control" placeholder="e.g., Site Engineer">
                            </div>
                            <div class="col-md-6">
                                <label>Project Area</label>
                                <input type="text" class="form-control"
                                    placeholder="e.g., Foundation, Roofing" required>
                            </div>
                            <div class="col-md-6">
                                <label>Weather</label>
                                <select class="form-select">
                                    <option>Sunny</option>
                                    <option>Cloudy</option>
                                    <option>Rainy</option>
                                    <option>Stormy</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label>Work Summary</label>
                                <textarea class="form-control" rows="3"
                                    placeholder="Brief of work completed today" required></textarea>
                            </div>
                            <div class="col-12">
                                <label>Upload Photos (optional)</label>
                                <input type="file" class="form-control" multiple>
                            </div>
                            <div class="col-12">
                                <label>Remarks / Issues</label>
                                <textarea class="form-control" rows="2"
                                    placeholder="Any notes or problems on site"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-dark">Save Work Log</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Task Timeline Tracking -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Task Timeline</b></h1>
            <a href="#" data-bs-toggle="modal" data-bs-target="#logEntryModal"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus text-white-50"></i> Add Task
            </a>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Task</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Status</th>
                                <th>Timeline (Days)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Excavation</td>
                                <td>2025-07-01</td>
                                <td>2025-07-05</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bar-completed" style="width: 100%">5 Days
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Foundation Pouring</td>
                                <td>2025-07-06</td>
                                <td>2025-07-12</td>
                                <td><span class="badge bg-warning text-dark">In Progress</span></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bar-progress" style="width: 60%">4/7 Days
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Framing</td>
                                <td>2025-07-13</td>
                                <td>2025-07-25</td>
                                <td><span class="badge bg-secondary">Planned</span></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bar-planned" style="width: 0%">0%</div>
                                    </div>
                                </td>
                            </tr>
                            <!-- More tasks -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add   Modal -->
            <div class="modal fade" id="addTaskModal" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Task Name</label>
                                <input type="text" class="form-control"
                                    placeholder="e.g., Brickwork for Ground Floor" required>
                            </div>

                            <div class="mb-3">
                                <label>Assigned To</label>
                                <input type="text" class="form-control"
                                    placeholder="e.g., Site Engineer / Contractor Name">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Status</label>
                                <select class="form-select">
                                    <option selected disabled>Select Status</option>
                                    <option>Planned</option>
                                    <option>In Progress</option>
                                    <option>Completed</option>
                                    <option>Delayed</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Progress (%)</label>
                                <input type="number" class="form-control" placeholder="e.g., 40" min="0"
                                    max="100">
                            </div>

                            <div class="mb-3">
                                <label>Additional Notes (optional)</label>
                                <textarea class="form-control" rows="3"
                                    placeholder="Details, dependencies, remarks..."></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Client Feedback & Approval -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Client Feedback & Approval</b></h1>
            <a href="#" data-bs-toggle="modal" data-bs-target="#feedbackModal"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus text-white-50"></i> Submit Feedback
            </a>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Subject</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2025-06-30</td>
                                <td>Approve new floor plan</td>
                                <td>Looks good. Please proceed with structural changes.</td>
                                <td><span class="badge bg-success">Approved</span></td>
                                <td><a href="#">View</a></td>
                            </tr>
                            <!-- More feedback rows -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add   Modal -->
            <div class="modal fade" id="feedbackModal" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Submit Feedback / Approval</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Subject</label>
                                <input type="text" class="form-control"
                                    placeholder="e.g., Approval for layout changes" required>
                            </div>
                            <div class="mb-3">
                                <label>Comment / Feedback</label>
                                <textarea class="form-control" rows="4"
                                    placeholder="Enter your remarks or approval here..."
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select class="form-select" required>
                                    <option selected disabled>Select</option>
                                    <option>Approved</option>
                                    <option>Needs Change</option>
                                    <option>Rejected</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Upload File (optional)</label>
                                <input type="file" class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-success" type="submit">Submit Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Team & Contractor Assignment -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Team & Contractor Assignment</b></h1>
            <a href="#" data-bs-toggle="modal" data-bs-target="#assignTeamModal"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus text-white-50"></i> Submit Feedback
            </a>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Task</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Arun Singh</td>
                                <td>Site Engineer</td>
                                <td>Excavation</td>
                                <td>+91-9098575855</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>Reporting daily updates</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                </td>
                            </tr>
                            <!-- More assignments -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add   Modal -->
            <div class="modal fade" id="assignTeamModal" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign New Team Member / Contractor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Full Name</label>
                                <input type="text" class="form-control" placeholder="e.g., Rajeev Kumar"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>Role</label>
                                <select class="form-select" required>
                                    <option selected disabled>Select Role</option>
                                    <option>Site Engineer</option>
                                    <option>Electrician</option>
                                    <option>Plumber</option>
                                    <option>Contractor</option>
                                    <option>Supervisor</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Assigned Area / Task</label>
                                <input type="text" class="form-control"
                                    placeholder="e.g., Electrical Work - 1st Floor">
                            </div>
                            <div class="mb-3">
                                <label>Contact Number</label>
                                <input type="text" class="form-control" placeholder="e.g., +91-9123456789">
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select class="form-select">
                                    <option>Active</option>
                                    <option>On Leave</option>
                                    <option>Replaced</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Remarks</label>
                                <textarea class="form-control" rows="2"
                                    placeholder="Any instructions or notes"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Document Manager -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0"><b>Document Manager</b></h1>
            <a href="#" data-bs-toggle="modal" data-bs-target="#uploadDocModal"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus text-white-50"></i> Upload Document
            </a>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Uploaded By</th>
                                <th>Date</th>
                                <th>File</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Excavation Layout</td>
                                <td>Drawing</td>
                                <td>Architect</td>
                                <td>2025-06-25</td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                <td>Approved for foundation level</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </td>
                            </tr>
                            <!-- More docs -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add   Modal -->
            <div class="modal fade" id="uploadDocModal" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload New Document</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" class="form-control"
                                    placeholder="e.g., Electrical Layout Plan" required>
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select class="form-select" required>
                                    <option selected disabled>Select Type</option>
                                    <option>Drawing</option>
                                    <option>Approval</option>
                                    <option>Checklist</option>
                                    <option>Contract</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Upload File</label>
                                <input type="file" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Notes</label>
                                <textarea class="form-control" rows="2"
                                    placeholder="Any remarks or document info"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-dark" type="submit">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection