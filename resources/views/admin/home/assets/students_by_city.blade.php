<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>مزود الخدمةين حسب المركز</h5>
        <button class="btn btn-sm btn-success ml-auto" onclick="downloadCanvas('students_by_city')"><i class="fa fa-download"></i></button>
    </div>
    <div class="card-body">
        <div>
            <canvas id="students_by_city"></canvas>
        </div>
    </div>
    <div class="card-footer text-left">
        <a class="btn btn-sm btn-info" onclick="smoothLoader(this)" href="{{route('admin.statistics.cities')}}?type=in_groups">عرض المزيد</a>
    </div>
</div>

@push('push_scripts')

    <script>
        let students_by_cityCtx = document.getElementById("students_by_city").getContext('2d');
        let students_by_cityChart = new Chart(students_by_cityCtx, {
            type: 'bar',
            data: {
                labels: "<?php echo implode(",", $studentsInCities['cities']); ?>".split(","),
                datasets: [{
                    label: 'متدرب',
                    data: "<?php echo implode(",", $studentsInCities['total']); ?>".split(","),
                    backgroundColor: '#ccccff',
                    borderColor: '#0000ff',
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
