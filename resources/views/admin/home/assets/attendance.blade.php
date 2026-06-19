<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>نسبة الحضور والغياب طبقا للمجموعات</h5>
        <button class="btn btn-sm btn-success ml-auto" onclick="downloadCanvas('absent_vs_present')"><i class="fa fa-download"></i></button>
    </div>
    <div class="card-body">
        <div style="height: 300px">
            <canvas id="absent_vs_present"></canvas>
        </div>
    </div>
    <div class="card-footer">
        <a class="btn btn-sm btn-info" onclick="smoothLoader(this)"
           href="{{route('admin.statistics.attendance')}}">عرض المزيد</a>
    </div>
</div>

@push('push_scripts')

    <script>
        let absent_vs_presentCtx = document.getElementById("absent_vs_present").getContext('2d');
        let absent_vs_presentVmyChart = new Chart(absent_vs_presentCtx, {
            type: 'bar',
            data: {
                labels: "<?php echo implode(",", $getAttendanceTotal['groups']); ?>".split(","),
                datasets: [
                    {
                        label: 'غياب',
                        data: "<?php echo implode(",", $getAttendanceTotal['absent']); ?>".split(","),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255,99,132,1)',
                    },
                    {
                        label: 'حضور',
                        data: "<?php echo implode(",", $getAttendanceTotal['present']); ?>".split(","),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                    }
                ]

            },
            options: {
                responsive: true,
                animation: false,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value, index, values) {
                                return value + ' %';
                            },
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
