@extends('layouts.app')

@section('stylesheet')
<style>
    .pagelink {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        cursor: pointer;
    }

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
    <a href="{{url('points')}}" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink"><i class="fa fa-user"></i> Points</a>
    <a href="javascript:;" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink active"><i class="fa fa-user"></i> Adjudicator</a>
    <a href="{{url('bets')}}" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink"><i class="fa fa-user"></i> Bets</a>
</div>

<!-- Widgets Card -->
<div class="card mb-3 mb-md-4">
    <div class="row align-items-center mb-3">
        <div class="col-md-auto d-flex align-items-center m-3">
            <span class="text-muted mr-2">Show:</span>

            <select id="datatableEntries" class="js-custom-select" data-classes="select-simple">
                <option value="5" selected>5 entries</option>
                <option value="10">10 entries</option>
                <option value="15">15 entries</option>
                <option value="25">25 entries</option>
            </select>
        </div>
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
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3">options</th>
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">number of players</th>
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-center">status</th>
                    <th class="font-weight-normal text-muted text-capitalize py-2 py-md-3 text-right">actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($adjudicatedBets as $bet)
                <tr>
                    <td class="py-2 py-md-3" style="min-width:auto">{{$bet->title}}</td>
                    <td class="py-2 py-md-3">{{implode(' | ', array_pluck($bet->options, 'title'))}}</td>
                    <td class="py-2 py-md-3 text-center">{{count($bet->players)}}</td>
                    <td class="py-2 py-md-3 text-center">{{$bet->status_label}}</td>
                    <td class="text-right">
                        @if($bet->status<=2)
                        <div class="position-relative">
                            <a id="dropDown29Invoker" class="btn btn-sm btn-outline-primary d-flex align-items-center dropdown-toggle text-left" href="#" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">Actions
                                <i class="nova-angle-down icon-text icon-text-xs ml-2 ml-lg-auto"></i>
                            </a>

                            <ul class="unfold unfold-light dropdown-menu px-0 py-3 mt-1" aria-labelledby="dropDown29Invoker" style="min-width: 150px; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);" x-placement="bottom-start">
                                @if($bet->status<=1)
                                <li class="unfold-item">
                                    <a class="edit-bet unfold-link media align-items-center text-nowrap" iid="{{$bet->id}}" href="#">
                                        <i class="nova-pencil unfold-item-icon mr-3"></i>
                                        <span class="media-body">Edit</span>
                                    </a>
                                </li>
                                @endif

                                @if($bet->status==2)
                                <li class="unfold-item">
                                    <a class="award-winner unfold-link media align-items-center text-nowrap" iid="{{$bet->id}}" href="#">
                                        <i class="nova-medall unfold-item-icon mr-3"></i>
                                        <span class="media-body">Award</span>
                                    </a>
                                </li>
                                @endif

                                @if($bet->status<=2)
                                <li class="unfold-item">
                                    <a class="cancel-bet unfold-link media align-items-center text-nowrap" iid="{{$bet->id}}" href="#">
                                        <i class="nova-close unfold-item-icon mr-3"></i>
                                        <span class="media-body">Cancel</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(count($adjudicatedBets))
    <div class="card-footer d-block d-md-flex align-items-center">
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

<div id="awardModal" class="modal fade" role="dialog" aria-labelledby="awardModal" aria-hidden="false">
    <div class="modal-dialog modal-bg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-capitalize award-bet-title">
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="award-bet-description">
                </p>

                <h6>Placed bets</h6>

                <ul class="award-player-list" style="list-style:none;">
                    <li class="bet-info-input mb-1">
                        <input type="checkbox" iid="">
                        <span></span>
                    </li>

                </ul>
                <div class="alert alert-info" role="alert">

                </div>

            </div>
            <div class="modal-footer">
                <span class="text-danger">
                    Don't make a mistake. This can't be undone.
                </span>
                <button type="button" class="do-award btn btn-primary">Award Winner</button>

            </div>
        </div>
    </div>
</div>

@include('partials.createbet')

<script type="text/javascript">

    $(document).on('ready', function() {
        $.HSCore.components.HSDatatables.init('.bet-table', {ordering:false});

        $(document).on('change', '.award-player-list input', function(e){
            var checked = this.checked
            $('.award-player-list input').prop('checked', false)

            $('.award-player-list input[answer='+$(this).attr('answer')+']').prop('checked', checked)
        })

        //bet cancel
        $(document).on('click', '.cancel-bet', function(){
            var betId = $(this).attr('iid');

            Swal.fire({
                title: 'Are you sure?',
                text: "Are you want to cancel this bet?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.value && result.value===true) {

                    $.LoadingOverlay("show")

                    $.post(BASE_URL + '/adjudicator/cancel-bet', {id: betId}, function (r) {

                        $.LoadingOverlay("hide")
                        if(r=='ok'){

                            Swal.fire(
                            'Canceled!',
                            'The bet has been canceled.',
                            'success'
                            ).then(()=>{
                                location.reload();
                            })
                        }
                    })
                }
            })

        })

        //bet edit action
        $(document).on('click', '.edit-bet', function(){
            var betId = $(this).attr('iid')
            $.get('/adjudicator/get-bet/' + betId, function(r){
                if(typeof r['id']==undefined){
                    Swal.fire('Didn\'t get this bet information.', '', 'warning');
                    return;
                }

                //bet modal

                $('[_t="bet title"]').text(r.title)
                $('[_t="bet description"]').text(r.description)
                $('.bet-options').empty()

                $(r.options).map(function(i, el){
                    var html = '<li class="bet-info-input mb-1">' +
                                    '<input type=radio name=options '+ (el.is_answer?'checked':'') +'>' +
                                    '<span>'+ el.title +'</span>' +
                                    '<a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a>' +
                                    '<a href="javascript:;" class="ml-1 delete-trigger"><i class="nova-trash icon-text"></i></a>' +
                                '</li>';
                    $('.bet-options').append(html)
                })

                $('#expire').val(r.expire);

                //bet modal ended

                //player modal
                $('.player-list').empty()

                $(r.players).map(function(i, el){
                    if(el.invited_email=='{{auth()->user()->email}}'){
                        return;
                    }

                    var html = '<li class="player-item mb-1">'+
                                    '<span title="'+el.invited_email+'">'+el.invited_name+'</span>'+
                                    '<a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a>'+
                                    '<a href="javascript:;" class="ml-1 delete-trigger"><i class="nova-trash icon-text"></i></a>'+
                                '</li>';
                    $('.player-list').append(html);
                })

                //player modal ended
                $('.save-bet').attr('iid', r.id)
                $('#betinfoModal').modal()
            })
        })

        //bet award modal
        $(document).on('click', '.award-winner', function(){
            var betId = $(this).attr('iid')

            $.get('/adjudicator/get-bet/' + betId, function(r){
                if(typeof r['id']==undefined){
                    Swal.fire('Didn\'t get this bet information.', '', 'warning');
                    return;
                }

                //bet modal
                $('.award-bet-title').text(r.title)
                $('.award-bet-description').text(r.description)
                $('.award-player-list').empty().attr('bet-id', betId)

                var voted = 0, resultTxt='';

                $(r.players).map(function(i, el){

                    var optionText = ' --- ';

                    if(el.betting_option_id){

                        voted += 1
                        var votedOption = _.find(r.options, {id:el.betting_option_id})

                        if(votedOption){
                            optionText = votedOption.title
                        }
                    }

                    var html = '<li class="bet-info-input mb-1">'+
                                    '<input type="checkbox" iid="'+el.invited_email+'" '+(el.betting_option_id?'':'disabled')+' answer="'+el.betting_option_id+'"> '+
                                    '<span>'+el.invited_name+' ( '+optionText+' )</span>'+
                                '</li>';

                    $('.award-player-list').append(html)
                })

                $('#awardModal .alert').text(voted + ' from '+r.players.length+' peoples have voted already.')

                $('#awardModal').modal()
            })
        })

        //bet cancel
        $(document).on('click', '.do-award', function(){
            var betId = $('.award-player-list').attr('bet-id');

            if(!$('.award-player-list input:checked').length){
                Swal.fire('Please check winners option', '', 'warning')
                return;
            }

            var winners = []

            $('.award-player-list input:checked').map(function(i, el){
                winners.push($(el).attr('iid'));
            })

            // $('.award-player-list').empty().attr('bet-id', betId)
            Swal.fire({
                title: 'Are you sure?',
                text: "This operation can't be undone.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, award it'
            }).then((result) => {
                if (result.value && result.value===true) {

                    $.LoadingOverlay("show")

                    $.post(BASE_URL + '/adjudicator/award', {betId:betId, winners: winners}, function (r) {

                        $.LoadingOverlay("hide")

                        if(r=='ok'){

                            Swal.fire(
                            'Awarded!',
                            'The winners have been awarded.',
                            'success'
                            ).then(()=>{
                                location.reload();
                            })
                        }
                    })
                }
            })

        })

    })
</script>
@endsection
