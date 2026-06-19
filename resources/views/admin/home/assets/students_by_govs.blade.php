<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>مزود الخدمةين حسب المحافظة</h5>
        <button class="btn btn-sm btn-success ml-auto" onclick="downloadCanvas('student_in_gov_all')"><i class="fa fa-download"></i></button>
    </div>
    <div class="card-body">
        <div>
            <canvas id="student_in_gov_all"></canvas>
        </div>
    </div>
    <div class="card-footer text-left">
        <a class="btn btn-sm btn-info" onclick="smoothLoader(this)"
           href="{{route('admin.statistics.governorates')}}?type=in_groups">عرض المزيد</a>
    </div>
</div>

@push('push_scripts')

    <script>
        let student_in_gov_allCtx = document.getElementById("student_in_gov_all").getContext('2d');
        let students_by_go_allVmyChart = new Chart(student_in_gov_allCtx, {
            type: 'bar',
            data: {
                labels: "<?php echo implode(",", $studentsInGovernorates['governorates']); ?>".split(","),
                datasets: [{
                    label: 'متدرب',
                    data: "<?php echo implode(",", $studentsInGovernorates['total']); ?>".split(","),
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
