@extends('layouts.app')

@section('content')

<div class="card border mb-4">
    <div class="card-body bg-hero bg-hero-dark position-relative text-white p-3 p-md-4" style="background-image: url({{asset('/img/500x550/img5.jpg')}});">
        <h1 class="text-center my-9">
            <span class="font-weight-semi-bold text-uppercase">IcyBet</span>
        </h1>
        <h3 class="text-center">
            <a href="{{url('adjudicator?c=1')}}" class="btn btn-info">Create Bet</a>
        </h3>
    </div>

</div>

<div class="text-center">
    <a href="{{url('points')}}" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink"><i class="fa fa-user"></i> Points</a>
    <a href="{{url('adjudicator')}}" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink"><i class="fa fa-user"></i> Adjudicator</a>
    <a href="{{url('bets')}}" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink"><i class="fa fa-user"></i> Bets</a>
</div>

<div class="row align-items-center mb-3 mb-md-4">
    <div class="col-md mb-2 mb-md-0">
        <h1 class="h3 mb-0 text-uppercase">community leader board</h1>
    </div>

</div>

<div class="table-responsive-xl">
    <table class="bet-table table text-nowrap mb-0">
        <thead>
            <tr class="small">
                <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-right">points</th>
                <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3">name</th>
                <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">game played</th>
                <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">view bets</th>
            </tr>
        </thead>
        <tbody>
            @foreach($players as $player)
            <tr>
                <td class="py-2 py-md-3 text-right">{{$player->point?$player->point:'-'}}</td>
                <td class="py-2 py-md-3 text-capitalize">{{$player->name}}</td>
                <td class="py-2 py-md-3 text-center">{{count($player->games)}}</td>
                <td class="text-center">
                    <a href="javascript:;" iid="{{$player->email}}" class="bet-history-btn btn btn-circle btn-primary  btn-sm"><i class="nova-bar-chart"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection
@section('scripts')

@include('partials.createbet')

<div id="bethistoryModal" class="modal fade" role="dialog" aria-labelledby="betinfoModal" aria-hidden="false">
    <div class="modal-dialog modal-bg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-capitalize">
                    bet title
                </h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive-xl">
                    <table class="bet-history-table table text-nowrap mb-0">

                        <thead>
                            <tr class="small">
                                <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3">the challenge</th>
                                <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">option</th>
                                <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">point</th>
                            </tr>
                        </thead>

                        <tbody style="height:100vh;overflow:auto;">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).on('ready', function() {

        $(document).on('click', '.bet-history-btn', function(){
            $('#bethistoryModal .modal-title').text($(this).parent().prev().prev().text() + '\'s Betting History')

            $.get(BASE_URL + '/points/get-history/' + $(this).attr('iid'), function(r){
                $('.bet-history-table tbody').html(r)
            })

            $('#bethistoryModal').modal('show');
        })
    })
</script>
@endsection
