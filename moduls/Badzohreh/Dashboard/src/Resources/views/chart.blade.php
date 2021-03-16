<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    Highcharts.chart('container', {
        chart: {
            renderTo: 'container',
            style: {
                fontFamily: 'irs',
                textAlign: "right",
            }
        },
        lang: {
            viewFullscreen: "نمایش تمام صفحه",
            printChart: "پرینت",
            downloadCSV: "دانلود csv",
            downloadJPEG: "دانلود تصویر (jpeg)",
            downloadPDF: "دانلود پی دی اف",
            downloadPNG: "دانلود تصویر (png)",
            downloadSVG: "دانلود تصویر (svg)",
            downloadXLS: "دانلود فایل excel",
            viewData: "نمایش به صورت جدول",
        }, tooltip: {
            useHTML: true,
            style: {
                direction: 'rtl',
                textAlign: "right",
            },
            formatter: function () {
                var mydate = this.x ? "تاریخ:" + "<span style='direction: ltr'>" + this.x + "</span><br />" : "";
                return mydate + "مبلغ:" + "<span style='margin-right: 10px'>" + this.y + "</span>";
            }
        }, title: {
            text: 'نمودار فروش 30 روز گذشته'
        },
        xAxis: {
            categories: [@foreach($dates as $date => $value) '{{ \Morilog\Jalali\Jalalian::fromCarbon(\Illuminate\Support\Carbon::parse($date))->format("Y-m-d") }}', @endforeach],
        }, yAxis: {
            title: {
                text: "مبلغ",
                style: {
                    fontSize: '20px',
                    fontWeight: 'bold',
                }
            }, labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        series: [{
            type: 'column',
            name: 'فروش سایت',
            color: '#red',
            data: [@foreach($dates as $date=>$value) @if($day = $summry->where("date",$date)->first()) {{ $day->totalSiteShare }} @else 0  @endif , @endforeach]
        }, {
            type: 'column',
            name: 'کل فروش',
            color: 'blue',

            data: [@foreach($dates as $date=>$value) @if($day = $summry->where("date",$date)->first()) {{ $day->amount }} @else 0  @endif , @endforeach]
        }, {
            type: 'column',
            name: 'فروش مدرس',
            color: 'pink',
            data: [@foreach($dates as $date=>$value) @if($day = $summry->where("date",$date)->first()) {{ $day->totalSellerShare }} @else 0  @endif , @endforeach]
        }, {
            type: 'spline',
            name: 'فروش',
            color: '#fcd5ce',
            data: [@foreach($dates as $date=>$value) @if($day = $summry->where("date",$date)->first()) {{ $day->amount }} @else 0  @endif , @endforeach],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        },]
    });
</script>
