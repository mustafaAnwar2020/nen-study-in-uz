<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>مزود الخدمةين حسب المجموعات</h5>
        <button class="btn btn-sm btn-success ml-auto" onclick="downloadCanvas('students_in_groups')"><i class="fa fa-download"></i></button>
    </div>
    <div class="card-body">
        <div style="height: 300px">
            <canvas id="students_in_groups"></canvas>
        </div>
    </div>
    <div class="card-footer text-left">
        <a class="btn btn-sm btn-info" onclick="smoothLoader(this)"
           href="{{route('admin.statistics.groups')}}?type=in_groups">عرض المزيد</a>
    </div>
</div>

@push('push_scripts')

    <script>
        let students_in_groupsCtx = document.getElementById("students_in_groups").getContext('2d');
        let students_in_groupsVmyChart = new Chart(students_in_groupsCtx, {
            type: 'bar',
            data: {
                labels: "<?php echo implode(",", $getTotalStudentsInGroups['groups']); ?>".split(","),
                datasets: [{
                    label: 'متدرب',
                    data: "<?php echo implode(",", $getTotalStudentsInGroups['total']); ?>".split(","),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]

            },
            options: {
                responsive: true,
                animation: false,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 18,
                            padding: 0,
                            fontColor: '#000'
                        }
                    }]
                }
            }
        });
    </script>
@endpush
