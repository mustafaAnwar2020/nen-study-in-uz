<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>الفئات العمرية ككل</h5>
        <button class="btn btn-sm btn-success ml-auto" onclick="downloadCanvas('age_classifications')"><i class="fa fa-download"></i></button>
    </div>
    <div class="card-body">
        <div>
            <canvas id="age_classifications"></canvas>
        </div>
    </div>

    <div class="card-footer">
        <a class="btn btn-sm btn-info" onclick="smoothLoader(this)"
           href="{{route('admin.age_classification.index')}}?type=in_groups">عرض المزيد</a>
    </div>
</div>

@push('push_scripts')

    <script>
        let age_classificationsCTX = document.getElementById("age_classifications").getContext('2d');
        let age_classificationsChart = new Chart(age_classificationsCTX, {
            type: 'bar',
            data: {
                labels: ['أقل من 18', '18 الي 25', '25 الي 30', '30 الي 35', '35 الي 40', 'أكثر من 40'],
                datasets: [{
                    label: 'سنة',
                    data: "<?php echo implode(",", $getUsersByAge); ?>".split(","),
                    backgroundColor: "rgba(255, 99, 132, 0.5)",
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
