@extends('visualmodule::layouts.master')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Organization Dashboard</h1>

    <!-- Chart Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Pie Chart -->
        <div class="bg-white p-6 shadow rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Organizations by Status</h2>
            <canvas id="orgStatusChart" class="w-full h-auto"></canvas>
        </div>

        <!-- Bar Chart -->
        <div class="bg-white p-6 shadow rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Organisations having highest number of users</h2>
            <canvas id="usersPerOrgChart" class="w-full h-auto"></canvas>
        </div>

        <!-- Line Chart -->
        <div class="bg-white p-6 shadow rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Activities by Status</h2>
            <canvas id="activityStatusChart" class="w-full h-auto"></canvas>
        </div>

        <!-- Doughnut Chart -->
        <div class="bg-white p-6 shadow rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Activities per Upload Medium</h2>
            <canvas id="activitiesByUploadMediumChart" class="w-full h-auto"></canvas>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script>

    const orgStatusData = @json($orgStatusData);

    const usersPerOrgData = @json($usersPerOrgData);

    const activityStatusData = @json($activityStatusData);

    const activitiesByUploadMedium = @json($activityByUploadMedium)

    // Organizations by Status (Pie Chart)
    const ctxOrgStatus = document.getElementById('orgStatusChart').getContext('2d');
    new Chart(ctxOrgStatus, {
        type: 'pie',
        data: {
            labels: Object.keys(orgStatusData),
            datasets: [{
                label: 'Number of Users',
                data: Object.values(orgStatusData),
                backgroundColor: ['#3B82F6', '#10B981'],
            }]
        }
    });

    // Users per Organization (Bar Chart)
    const ctxUsersPerOrg = document.getElementById('usersPerOrgChart').getContext('2d');
    new Chart(ctxUsersPerOrg, {
        type: 'bar',
        data: {
            labels: Object.keys(usersPerOrgData),
            datasets: [{
                label: 'Number of Users',
                data: Object.values(usersPerOrgData),
                backgroundColor: '#6366F1',
            }]
        }
    });

    // Activities by Status (Line Chart)
    const ctxActivityStatus = document.getElementById('activityStatusChart').getContext('2d');
    new Chart(ctxActivityStatus, {
        type: 'line',
        data: {
            labels: Object.keys(activityStatusData),
            datasets: [{
                label: 'Number of Activities',
                data: Object.values(activityStatusData),
                borderColor: '#EF4444',
                fill: false,
            }]
        }
    });

    // Activities By Upload Medium (Doughnut Chart)
    const ctxActivitiesByUploadMedium = document.getElementById('activitiesByUploadMediumChart').getContext('2d');
    new Chart(ctxActivitiesByUploadMedium, {
        type: 'doughnut',
        data: {
            labels: Object.keys(activitiesByUploadMedium),
            datasets: [{
                data: Object.values(activitiesByUploadMedium),
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
            }]
        }
    });
</script>
@endsection
