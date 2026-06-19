<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>طلبات الإلتحاق نسبة إلي وسيلة التعارف</h5>
        <button class="btn btn-sm btn-success ml-auto" onclick="downloadCanvas('method_all')"><i class="fa fa-download"></i></button>
    </div>
    <div class="card-body">
        <div style="height: 300px">
            <canvas id="method_all"></canvas>
        </div>
    </div>
    <div class="card-footer">
        <a class="btn btn-sm btn-info" onclick="smoothLoader(this)"
           href="{{route('admin.statistics.acquaintance')}}?type=in_applications">عرض المزيد</a>
    </div>
</div>

@push('push_scripts')

    <script>
        let method_allCtx = document.getElementById("method_all").getContext('2d');
        let method_allVmyChart = new Chart(method_allCtx, {
            type: 'bar',
            data: {
                labels: "<?php echo implode(",", $getAcquaintanceTotal['data']); ?>".split(","),
                datasets: [{
                    label: 'متدرب',
                    data: "<?php echo implode(",", $getAcquaintanceTotal['total']); ?>".split(","),
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
