<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>نسبة الذكور إلى الاناث بالبرامج</h5>
        <button class="btn btn-sm btn-success ml-auto" onclick="downloadCanvas('students_by_program')"><i class="fa fa-download"></i></button>
    </div>
    <div class="card-body">
        <div>
            <canvas id="students_by_program" height="243"></canvas>
        </div>
    </div>
    <div class="card-footer text-left">
        <a class="btn btn-sm btn-info" onclick="smoothLoader(this)"
           href="{{route('admin.males_vs_females.index')}}?type=in_groups">عرض المزيد</a>
    </div>
</div>

@push('push_scripts')

    <script>
        let students_by_programCtx = document.getElementById("students_by_program").getContext('2d');
        let students_by_programChart = new Chart(students_by_programCtx, {
            type: 'bar',
            data: {
                labels: "<?php echo implode(",", $studentsGenderByProgram['courses']); ?>".split(","),
                datasets: [
                    {
                        label: 'ذكور',
                        data: "<?php echo implode(",", $studentsGenderByProgram['males']); ?>".split(","),
                        backgroundColor: '#ccccff',
                    },
                    {
                        label: 'إناث',
                        data: "<?php echo implode(",", $studentsGenderByProgram['females']); ?>".split(","),
                        backgroundColor: "rgba(255, 99, 132, 0.5)",
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
                            fontSize: 18,
                            padding: 0,
                            fontColor: '#000'
                        }
                    }]
                },
            },
        });

    </script>
@endpush
