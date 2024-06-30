<ul class="pagination pagination-month justify-content-center">
    <li class="page-item">
        <a class="page-link" href="{{route('eh.payroll.index').'?year='.($year-1).'&month=12'.'&s='.$status}}">«</a>
    </li>
    @for($monthNum = 1;$monthNum<=12;$monthNum++)
        @php
            $monthUrl = date('m', mktime(0, 0, 0, $monthNum, 10));
            $monthName = date('M', mktime(0, 0, 0, $monthNum, 10));
        @endphp
        <li class="page-item @if($monthUrl==$month) active @endif">
            <a class="page-link" href="{{route('eh.payroll.index').'?year='.($year).'&month='.$monthUrl.'&s='.$status}}">
                <p class="page-month">{{$monthName}}</p>
                <p class="page-year">{{$year}}</p>
            </a>
        </li>
    @endfor
    <li class="page-item"><a class="page-link" href="{{route('eh.payroll.index').'?year='.($year+1).'&month=01'.'&s='.$status}}">»</a></li>
</ul>
