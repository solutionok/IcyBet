@extends('layouts.app')

@section('stylesheet')
<style>
    .flatpickr-month {
        padding: 0 !important;
    }

    .bet-options {
        list-style: none;
        padding-left: 10px;
    }
</style>
@endsection
@section('content')

<div class="text-center">
    <a href="{{url('points')}}" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink "><i class="fa fa-user"></i> Points</a>
    <a href="{{url('adjudicator')}}" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink"><i class="fa fa-user"></i> Adjudicator</a>
    <a href="javascript:;" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink active"><i class="fa fa-user"></i> Bets</a>
</div>


<!-- Widgets Card -->
<div class="card mb-3 mb-md-4">
    <div class="card-header border-bottom p-0">
        <ul class="nav nav-v2 nav-primary nav-justified d-block d-xl-flex w-100">
            <li class="nav-item border-bottom border-xl-bottom-0">
                <a href="{{url('bets?c=opened')}}" class="nav-link d-flex align-items-center py-2 px-3 p-xl-4 {{$flag=='opened'?'active':''}}">
                    <span>Open Bets</span>
                </a>
            </li>
            <li class="nav-item border-bottom border-xl-bottom-0 border-xl-left">
                <a href="{{url('bets?c=closed')}}" class="nav-link d-flex align-items-center py-2 px-3 p-xl-4 {{$flag=='closed'?'active':''}}">
                    <span>Closed Bets</span>
                </a>
            </li>
        </ul>
    </div>


    <div class="table-responsive-xl">
        <table class="bet-table table text-nowrap mb-0"
            data-dt-ordering="false"
            data-dt-info="#datatableInfo"
            data-dt-entries="#datatableEntries"
            data-dt-is-show-paging="true"
            data-dt-pagination="datatablePagination"
            data-dt-page-length="5"
            data-dt-is-responsive="false"
            data-dt-pagination-classes="pagination justify-content-end font-weight-semi-bold mb-0"
            data-dt-pagination-items-classes="page-item d-none d-md-block"
            data-dt-pagination-links-classes="page-link"
            data-dt-pagination-next-classes="page-item"
            data-dt-pagination-next-link-classes="page-link"
            data-dt-pagination-next-link-markup='<i class="nova-angle-right icon-text icon-text-xs d-inline-block"></i>'
            data-dt-pagination-prev-classes="page-item"
            data-dt-pagination-prev-link-classes="page-link"
            data-dt-pagination-prev-link-markup='<i class="nova-angle-left icon-text icon-text-xs d-inline-block"></i>'>

            <thead>
                <tr class="small">
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3">the challenge</th>
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">options</th>
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">number of players</th>
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">status</th>
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">your choice</th>
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">actions</th>
                </tr>
            </thead>

            <tbody>
                @php
                $statusLabels = [
                    0 => 'editing',
                    1 => 'opened',
                    2 => 'opened',
                    3 => 'canceled',
                    4 => 'completed'
                ];
                @endphp
                @foreach($mybets as $i=>$bet)
                <tr>
                    <td class="py-2 py-md-3" style="min-width:auto">{{$bet->title}}</td>
                    <td class="py-2 py-md-3 text-center">{{$bet->options}}</td>
                    <td class="py-2 py-md-3 text-center">{{$bet->player_num}}</td>
                    <td class="py-2 py-md-3 text-center">{{@$statusLabels[$bet->status]}}</td>
                    <td class="py-2 py-md-3 text-center">{{$bet->chosen}}</td>
                    <td class="text-center">
                        @if($bet->status<=2 && !$bet->betting_option_id)
                        <a href="javascript:;" iid="{{$bet->bet_id}}" playerid="{{$bet->id}}" class="betting-btn btn btn-circle btn-primary btn-sm" title="Betting..."><i class="nova-pencil"></i></a>
                        <a href="javascript:;" iid="{{$bet->bet_id}}" class="invit-friend-btn btn btn-circle btn-primary btn-sm" title="Inviting..."><i class="nova-user"></i></a>

                        @elseif($bet->status==4)
                        <a href="javascript:;" iid="{{$bet->bet_id}}" playerid="{{$bet->id}}" class="view-bet-btn btn btn-circle btn-primary btn-sm"><i class="nova-bar-chart"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(count($mybets))
    <div class="card-footer d-block d-md-flex align-items-center">
        <div class="col-md-auto d-flex align-items-center">
            <span class="text-muted mr-2">Show:</span>

            <select id="datatableEntries" class="js-custom-select" data-classes="select-simple">
                <option value="5" selected>5 entries</option>
                <option value="10">10 entries</option>
                <option value="15">15 entries</option>
                <option value="25">25 entries</option>
            </select>
        </div>
        <div id="datatableInfo" class="d-flex mb-2 mb-md-0"></div>
        <nav id="datatablePagination" class="d-flex ml-md-auto d-print-none" aria-label="Pagination"></nav>
    </div>
    @endif
    <!-- End Pagination -->

    <div class="card-footer d-print-none text-center">
        <a class="bet-create-btn btn btn-primary align-items-center font-weight-semi-bold text-capitalize" href="#">
            <i class="nova-plus icon-text mr-2"></i>
            <span>create new bet</span>
        </a>
    </div>
</div>
<!-- End Widgets Card -->

@endsection
@section('scripts')

@include('partials.createbet')

<div id="bettingModal" class="modal fade" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-bg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-capitalize bet-title">
                    bet title
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="bet-description">
                    bet description
                </p>
                <h6>Options</h6>
                <ul class="betting-options" style="list-style:none;">
                    <li class="mb-1">
                        <input type=radio name=options>
                        <span>New Option</span>
                    </li>

                </ul>

                <div>
                    Exprired Date : <span class="expire"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-do-bet">Lock it in</button>
            </div>
        </div>
    </div>
</div>

<div id="mybetModal" class="modal fade" role="dialog"  aria-hidden="false">
    <div class="modal-dialog modal-bg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-capitalize mybet-title">
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mybet-description">
                    bet description
                </p>
                <h6>Your Selection</h6>
                <ul class="mybet-options" style="list-style:none;">

                </ul>

                <div class="mybet-alt alert alert-dismissible alert-left-bordered border-warning bg-soft-warning d-flex align-items-center rounded-0 p-md-4 mb-2 fade show" role="alert">
                    <i class="nova-info-alt icon-text text-primary-darker mr-2"></i>
                    <p class="mb-0">

                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-do-bet">Lock it in</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).on('ready', function() {
        $.HSCore.components.HSDatatables.init('.bet-table', {ordering:false});

        $(document).on('click', '.view-bet-btn', function(){
            var betId = $(this).attr('iid');
            var playerId = $(this).attr('playerid');

            $.get(BASE_URL + '/adjudicator/get-bet/' + betId, function(r){
                if(r*1==-1){
                    Swal.fire('Your bet not available for now.', '', 'warning');
                    location.reload()
                }

                $('#mybetModal .mybet-title').text(r.title)
                $('#mybetModal .mybet-description').text(r.description)

                var mybet = _.find(r.players, {id:parseInt(playerId)});

                if(!mybet)return;

                $('.mybet-options').empty().attr('betid', mybet.id)

                r.options.map((el)=>{

                    var html = '<li class="mb-1">'+
                                    '<input type=radio name=options iid="'+el.id+'" '+(mybet.betting_option_id==el.id?'checked':'')+'> ' +
                                    '<span>'+el.title+'</span> '+
                                    (el.is_answer*1?' <i class="nova-cup"></i>':'') +
                                '</li>';
                    $('.mybet-options').append(html)
                })

                if(r.status==3){
                    var altMessage = 'This bet canceled!';
                }else if(r.status==4){
                    var point = mybet.earn_point*1;

                    var winners = []

                    r.players.map((el)=>{
                        if(el.earn_point*1>0){
                            winners.push(el.id==mybet.id?'You':el.invited_name)
                        }
                    })

                    var altMessage = 'In this round you got '+(point?point:'zero')+' points, '+(winners.join(', '))+' was the winner.';
                }

                $('.mybet-alt p').html(altMessage)

                $('#mybetModal').modal('show');
            })
        })

        $(document).on('click', '.betting-btn', function(){
            var betId = $(this).attr('iid');
            var playerId = $(this).attr('playerid');

            $.get(BASE_URL + '/adjudicator/get-bet/' + betId, function(r){
                if(r*1==-1){
                    Swal.fire('Your bet not available for now.', '', 'warning');
                    location.reload()
                }

                $('#bettingModal .bet-title').text(r.title)
                $('#bettingModal .bet-description').text(r.description)

                var mybet = _.find(r.players, {id:parseInt(playerId)});
                if(!mybet)return;

                $('.betting-options').empty().attr('betid', mybet.id)

                r.options.map((el)=>{
                    console.log(el)
                    var html = '<li class="mb-1">'+
                                    '<input type=radio name=options iid="'+el.id+'">' +
                                    '<span>'+el.title+'</span>'+
                                '</li>';
                    $('.betting-options').append(html)
                })

                $('.expire').text(r.expire)
                $('#bettingModal').modal('show');
            })
        })

        $(document).on('click', '.btn-do-bet', function(){
            if(!$('#bettingModal .betting-options input:checked').length){
                Swal.fire('Please place your bet', '', 'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure about the answer?',
                text: "It will get lock after place a bet until completed this game.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, sure it!'
            }).then((result) => {
                if (result.value && result.value===true) {
                    $.LoadingOverlay("show")

                    var data = {optionId:$('#bettingModal .betting-options input:checked').attr('iid'), playerId: $('.betting-options').attr('betid')}

                    $.post(BASE_URL + '/bets/place-bet', data, function(r){
                        location.href=BASE_URL + '/bets'
                    })
                }
            })
        })
    })
</script>
@endsection
