@extends('layouts.app')
@section('content')
@php
$barClass = $completedTaskPercent == 100
? 'bg-success'
: 'bg-info';
@endphp

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $projectsCount }}+</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹15,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$completedTaskPercent}} %</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar {{ $barClass }}" role="progressbar"
                                            style="width: {{$completedTaskPercent}}%" aria-valuenow="{{$completedTaskPercent}}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Client Management</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clientsCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <!-- <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                --Card Header - Dropdown --
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                ---Card Body --
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Tasks Completed by Month</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                            <a class="dropdown-item" href="#">Refresh</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Settings</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaTaskCharts"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <select
                        id="projectSelect"
                        class="form-select w-100"
                        data-url="{{ route('filter-tasks') }}">
                        <option value="">--- Select Project ---</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="card-body" id="taskStats">
                    <!-- Completed Tasks -->
                    <h4 class="small font-weight-bold">
                        Completed Tasks
                        <span class="float-right">
                            <span id="completedCount">0</span>
                            (<span id="completedPercent">0%</span>)
                        </span>
                    </h4>
                    <div class="progress mb-2">
                        <div
                            id="completedBar"
                            class="progress-bar bg-success"
                            role="progressbar"
                            style="width: 0%"
                            aria-valuenow="0"
                            aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                    <ul id="completedList" class="list-group mb-4"></ul>

                    <!-- In Progress Tasks -->
                    <h4 class="small font-weight-bold">
                        In Progress Tasks
                        <span class="float-right">
                            <span id="inprogressCount">0</span>
                            (<span id="inprogressPercent">0%</span>)
                        </span>
                    </h4>
                    <div class="progress mb-2">
                        <div
                            id="inprogressBar"
                            class="progress-bar bg-info"
                            role="progressbar"
                            style="width: 0%"
                            aria-valuenow="0"
                            aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                    <ul id="inprogressList" class="list-group"></ul>
                </div>
            </div>



        </div>

        <div class="col-lg-6 mb-4">

            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                </div>
                <div class="card-body">
                    <p> Construction is the process of building infrastructure, such as homes,
                        buildings, roads, and bridges. It involves stages like planning, design,
                        procurement, and execution. The industry includes various roles like architects,
                        engineers, contractors, and laborers. Technology like construction portals,
                        project management software, and site tracking tools now play a big role in
                        improving efficiency and safety.</p>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- End of Content Wrapper -->
<!-- Page level plugins -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Month labels
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // 2. Data passed from Controller
        const monthlyCounts = @json($monthlyCompleted);
        const monthlyProjects = @json($monthlyProjects);
        // console.log('monthlyCounts:', monthlyCounts);
        // console.log('monthlyProjects:', monthlyProjects);

        // 3. Build the numeric series
        const dataPoints = labels.map((_, idx) => monthlyCounts[idx + 1] || 0);

        // 4. Chart.js setup
        const ctx = document.getElementById('myAreaTaskCharts').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Completed Tasks',
                    data: dataPoints,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78,115,223,0.2)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(234,236,244,0.5)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            // First line: the count
                            label: ctx => `Tasks Completed: ${ctx.parsed.y}`,

                            // Second line: list of project names
                            afterLabel: ctx => {
                                const monthIndex = ctx.dataIndex + 1;
                                const names = monthlyProjects[monthIndex] || [];
                                if (!names.length) {
                                    return 'No projects completed';
                                }
                                // Show up to 5 names, then ellipsis
                                const display = names.length > 5 ?
                                    names.slice(0, 5).join(', ') + ', …' :
                                    names.join(', ');
                                return 'Projects: ' + display;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<script>
    $(function() {
        const reset = () => {
            $('#completedCount, #inprogressCount').text('0');
            $('#completedPercent, #inprogressPercent').text('0%');
            $('#completedBar, #inprogressBar')
                .css('width', '0%')
                .attr('aria-valuenow', 0);
            $('#completedList, #inprogressList').empty();
        };

        $('#projectSelect').on('change', function() {
            const projectId = $(this).val();
            const url = $(this).data('url');
            const token = $('meta[name="csrf-token"]').attr('content');

            if (!projectId) {
                return reset();
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    project_id: projectId,
                    _token: token
                },
                success(res) {
                    reset();

                    // Update Completed
                    $('#completedCount').text(res.completed);
                    $('#completedPercent').text(res.completedPercent + '%');
                    $('#completedBar')
                        .css('width', res.completedPercent + '%')
                        .attr('aria-valuenow', res.completedPercent);
                    res.completedTitles.forEach(title => {
                        $('#completedList').append(
                            `<li class="list-group-item">${title}</li>`
                        );
                    });

                    // Update In Progress
                    $('#inprogressCount').text(res.inProgress);
                    $('#inprogressPercent').text(res.inProgressPercent + '%');
                    $('#inprogressBar')
                        .css('width', res.inProgressPercent + '%')
                        .attr('aria-valuenow', res.inProgressPercent);
                    res.inProgressTitles.forEach(title => {
                        $('#inprogressList').append(
                            `<li class="list-group-item">${title}</li>`
                        );
                    });
                },
                error(xhr, status, error) {
                    console.error('Error loading tasks:', status, xhr.status, xhr.responseText);
                    reset();
                }
            });
        });
    });
</script>


@endsection