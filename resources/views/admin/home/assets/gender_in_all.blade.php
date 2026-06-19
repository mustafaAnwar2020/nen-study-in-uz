<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>نسبة الذكور إلى الاناث</h5>
        <button class="btn btn-sm btn-success ml-auto" onclick="downloadCanvas('male_female_all')"><i class="fa fa-download"></i></button>
    </div>
    <br>
    <br>
    <div class="card-body mb-1">
        <canvas id="male_female_all"></canvas>
    </div>
    <br>
    <br>
    <div class="card-footer text-left">
        <a class="btn btn-sm btn-info" onclick="smoothLoader(this)"
           href="{{route('admin.males_vs_females.index')}}?type=in_groups">عرض المزيد</a>
    </div>
</div>

@push('push_scripts')

    <script>
        let male_female_allCTX = document.getElementById("male_female_all").getContext('2d');
        let male_female_allChart = new Chart(male_female_allCTX, {
            type: 'pie',
            data: {
                labels: ['ذكور', 'إناث'],
                datasets: [{
                    label: 'النوع',
                    data: [{{$genderInGroups['males']}}, {{$genderInGroups['females']}}],
                    backgroundColor: ["#dbe8f2", "#fae2d6"],
                    hoverOffset: 4
                }],
            },
            options: {
                responsive: true,
                animation: false,
                maintainAspectRatio: false,
                cutoutPercentage: 50,
            }
        });
    </script>
@endpush
