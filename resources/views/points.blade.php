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
    <a href="javascript:;" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink active"><i class="fa fa-user"></i> Points</a>
    <a href="{{url('adjudicator')}}" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink"><i class="fa fa-user"></i> Adjudicator</a>
    <a href="{{url('bets')}}" class="nav-mobile-link btn btn-outline-primary border-0 mr-2 col-3 pagelink"><i class="fa fa-user"></i> Bets</a>
</div>

<!-- <div class="row align-items-center my-3">
    <div class="col-md mb-2 mb-md-0">
        <h1 class="h3 mb-0 text-uppercase">leader board</h1>
    </div>
</div> -->

<!-- Widgets Card -->
<div class="card mb-3 mb-md-4">


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
                    <td class="py-2 py-md-3 text-capitalize">{{$player->invited_name}}</td>
                    <td class="py-2 py-md-3 text-center">{{$player->play_count}}</td>
                    <td class="text-center">
                        <a href="javascript:;" iid="{{$player->invited_email}}" class="bet-history-btn btn btn-circle btn-primary  btn-sm"><i class="nova-bar-chart"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer d-block d-md-flex align-items-center">
        <div class="col-md-auto d-flex align-items-center m-3">
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
        $.HSCore.components.HSDatatables.init('.bet-table');

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
