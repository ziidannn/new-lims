@extends('layouts.master')
@section('title', 'Dashboard')


@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.css')}}">
<style>
    .default-datepicker .datepicker-inline .datepicker {
        width: auto;
        background: #fff;
        -webkit-box-shadow: none;
        box-shadow: none;
        padding: 0
    }

    .default-datepicker .datepicker-inline .datepicker .datepicker--content .datepicker--days .datepicker--days-names {
        margin: 60px 0 0;
        padding: 15px 0;
    }

    .default-datepicker .datepicker-inline .datepicker .datepicker--content .datepicker--days .datepicker--cells .datepicker--cell-day {
        height: 58px;
        border-radius: 0;
        color: #2b2b2b
        font-size: 20px
    }

    .default-datepicker .datepicker-inline .datepicker .datepicker--content .datepicker--days .datepicker--days-names .datepicker--day-name {
        color: #696CFF;
        font-size: 18px
    }

    .bg-card {
        background-image: url('{{asset('/assets/img/bg.jpg')}}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: white;
    }

    h3 {
        color: #fff;
    }

    #greeting {
        color: #fff
    }

    #txt {
        color: #fff
    }

    .f-w-600 {
        margin-right: 10px;
    }

    .profile-greeting .card-body {
        padding: 40px 20px
    }

</style>
@endsection

@section('content')
<div class="app-calendar-wrapper">
    <div class="row">
        <div class="col-xl-6 col-lg-10 xl-40 morning-sec box-col-8 mb-4">
            <div class="card profile-greeting bg-card">
                <div class="card-body pb-0" style="min-height: 550px;">
                    <div class="media">
                        <div class="media-body">
                            <div class="greeting-user m-0">
                                <div class="greeting-container">
                                    <h4 class="f-w-600 font-light m-0 mb-" id="greeting"></h4>
                                    <h4><span id="txt"></span></h4>
                                </div>
                                <h3>{{ Auth::user()->name }} <i class="email">({{ Auth::user()->email }})</i></h3>
                                @foreach(Auth::user()->roles as $x)
                                <i class="badge rounded-pill bg-primary">{{ $x->name }}</i>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div class="cartoon"><img class="img-fluid" src="{{asset('/assets/img/cartoon.png')}}"
                            style="max-width: 90%;" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 xl-50 calendar-sec box-col-6">
            <div class="card gradient-primary o-hidden">
                <div class="card-body pb-10" style="min-height: 550px;">
                    <div class="default-datepicker">
                        <div class="datepicker-here" data-language="en" style="max-width: 100%;" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(window).on('load', function () {
        $('#myModal').modal('show');
    });

</script>
<!-- <script src="{{asset('assets/js/notify/bootstrap-notify.min.js')}}"></script> -->
<script>
    // greeting
    var today = new Date()
    var curHr = today.getHours()

    if (curHr >= 0 && curHr < 4) {
        document.getElementById("greeting").innerHTML = 'Good Night!';
    } else if (curHr >= 4 && curHr < 12) {
        document.getElementById("greeting").innerHTML = 'Good Morning!';
    } else if (curHr >= 12 && curHr < 16) {
        document.getElementById("greeting").innerHTML = 'Good Afternoon!';
    } else {
        document.getElementById("greeting").innerHTML = 'Good Evening!';
    }
    // time
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        // var s = today.getSeconds();
        var ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        h = h ? h : 12;
        m = checkTime(m);
        // s = checkTime(s);
        document.getElementById('txt').innerHTML =
            h + ":" + m + ' ' + ampm;
        var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }

    startTime();

</script>
<!-- <script src="{{asset('assets/js/notify/index.js')}}"></script> -->
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
<script src="{{asset('assets/js/datepicker/daterange-picker/moment.min.js')}}"></script>

@endsection
