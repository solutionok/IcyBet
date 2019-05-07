<div class="createbetblock">
<div id="betinfoModal" class="modal fade" role="dialog" aria-labelledby="betinfoModal" aria-hidden="false">
    <div class="modal-dialog modal-bg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-capitalize bet-info-input">
                    <span _t="bet title">bet title</span>
                    <a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a>
                </h5>
            </div>
            <div class="modal-body">
                <p class="bet-info-textarea">
                    <span _t="bet description">Bet description</span>
                    <a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a>
                </p>

                <h6>Options</h6>

                <ul class="bet-options">
                    <li class="bet-info-input mb-1">
                        <input type=radio name=options>
                        <span>New Option</span>
                        <a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a>
                        <a href="javascript:;" class="ml-1 delete-trigger"><i class="nova-trash icon-text"></i></a>
                    </li>
                    <li class="bet-info-input mb-1">
                        <input type=radio name=options>
                        <span>New Option</span>
                        <a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a>
                        <a href="javascript:;" class="ml-1 delete-trigger"><i class="nova-trash icon-text"></i></a>
                    </li>
                    <li class="bet-info-input mb-1">
                        <input type=radio name=options>
                        <span>New Option</span>
                        <a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a>
                        <a href="javascript:;" class="ml-1 delete-trigger"><i class="nova-trash icon-text"></i></a>
                    </li>
                </ul>

                <a href="javascript:;" class="ml-2 add-option-trigger"><i class="nova-plus icon-text"></i></a>

                <div>
                    Exprired Date : <input type="text" id="expire" value="{{date('Y-m-d')}}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary bet-modal-next">Next</button>
            </div>
        </div>
    </div>
</div>

<div id="playerModal" class="modal fade" role="dialog" aria-labelledby="betinfoModal" aria-hidden="false">
    <div class="modal-dialog modal-bg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-capitalize">
                    Invite Players
                </h5>
            </div>
            <div class="modal-body">

                <h6>Players</h6>

                <ul class="player-list">


                </ul>

                <div class="input-group">
                    <img src="{{asset('img/icons/icons8-add-user-male-50.png')}}" style="width:30px;height:30px;margin:8px 8px 0 0;">
                    <input class="form-control invited_email" type="text" placeholder="Friends Email" list="friends-list">
                </div>

                <div class="input-group mt-1">
                    <input class="form-control invited_name" type="text"  placeholder="Friends Name" style="margin-left:38px;">
                    <div class="input-group-append input-group-append-infinity">
                        <a class="btn btn-sm btn-primary add-friend-btn" href="#">Add</a>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary back-to-bet" data-dismiss="modal">Back</button>
                <button type="button" class="btn btn-primary save-bet" iid="">Save & Send</button>
            </div>
        </div>
    </div>
</div>


<div id="inviteModal" class="modal fade" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-bg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-capitalize">
                    Invite Your Fiends
                </h5>
            </div>
            <div class="modal-body">
                <h6>Players</h6>

                <ul class="invite-player-list">


                </ul>

                <div class="input-group">
                    <img src="{{asset('img/icons/icons8-add-user-male-50.png')}}" style="width:30px;height:30px;margin:8px 8px 0 0;">
                    <input class="form-control invite-invited_email" type="text" placeholder="Friends Email" list="friends-list">
                </div>

                <div class="input-group mt-1">
                    <input class="form-control invite-invited_name" type="text"  placeholder="Friends Name" style="margin-left:38px;">
                    <div class="input-group-append input-group-append-infinity">
                        <a class="btn btn-sm btn-primary invite-add-friend-btn" href="#">Add</a>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                <button type="button" class="btn btn-primary invite-friends" iid="">Invite</button>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">

    $(document).on('ready', function() {

        /**
         * invit
         */
        //when pressed invite friend button in bets page
        $(document).on('click', '.invit-friend-btn', function(){
            $('#inviteModal .invite-player-list, #inviteModal .invite-invited_name, #inviteModal .invite-invited_email').empty().val('');
            $('#inviteModal .invite-friends').attr('iid', $(this).attr('iid'))

            $.get(BASE_URL + '/adjudicator/get-bet/' + $(this).attr('iid'), function(r){
                $('.invite-player-list').empty();

                r.players.map((el)=>{

                    var html = '<li class="player-item mb-1">'+
                                    '<span title="'+el.invited_email+'">'+el.invited_name+'</span>'+
                                '</li>';

                    $('#inviteModal .invite-player-list').append(html);
                })
                $('#inviteModal').modal();
            })
        })

        //when changed email that should added to list
        $('#inviteModal .invite-invited_email').change(function(){
            $(this).val($.trim($(this).val()))
            $('#inviteModal .invite-invited_email').val($.trim($('#inviteModal .invite-invited_email').val()))

            $('#friends-list').children().each(function(i, el){

                if($(el).val()==$.trim($('#inviteModal .invite-invited_email').val())){

                    $('#inviteModal .invite-invited_name').val($(el).attr('text'))
                }
            })
        })

        //when pressed email add button
        $('#inviteModal .invite-add-friend-btn').click(function(){
            var email = $.trim($('#inviteModal .invite-invited_email').val())
            var name = $.trim($('#inviteModal .invite-invited_name').val())

            if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
                $('#inviteModal .invite-invited_email').focus().select()
                Swal.fire('Please insert valid email!', '','warning');
                return;
            }

            if(!name){
                $('#inviteModal .invite-invited_name').focus().select()
                Swal.fire('Please insert valid name!','', 'warning');
                return;
            }
            var duplicatedMessage = ''

            $('#inviteModal .invite-player-list li').each((i, el)=>{
                if($('span', el).attr('title')==email){
                    duplicatedMessage = email + ' is already invited as ' + $(el).text();
                }
            })

            if(duplicatedMessage){
                Swal.fire(duplicatedMessage, '', 'warning');
                return;
            }

            var html = '<li class="player-item mb-1">'+
                            '<span title="'+email+'">'+name+'</span>'+
                            '<a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a>'+
                            '<a href="javascript:;" class="ml-1 delete-trigger"><i class="nova-trash icon-text"></i></a>'+
                        '</li>';
            $('#inviteModal .invite-player-list').append(html);

            $('#inviteModal .invite-invited_email').val('')
            $('#inviteModal .invite-invited_name').val('')

        })

        //invit friend action
        $('#inviteModal .invite-friends').click(function() {
            if (!$('#inviteModal .invite-player-list .delete-trigger').length) {
                Swal.fire('No have new friends to invite', '', 'warning');
                return;
            }
            var betId = $(this).attr('iid')
            var addedData = [];
            $('#inviteModal .invite-player-list .delete-trigger').map((i, el) => {
                var span = $(el).prev().prev();
                addedData.push({
                    email: $(span).attr('title'),
                    name: $(span).text()
                })
            })

            $.LoadingOverlay("show")

            $.post(BASE_URL + '/bets/invite-myfrinds', {bet_id: betId, friends: addedData}, function(r) {
                $.LoadingOverlay("hide")
                Swal.fire('Successfully invited your friends.', '', 'success')
                    .then(() => {
                        location.reload();
                    })
            })

            $('#inviteModal').modal('hide');
        })


        /**
         * create bet
         */
        //when changed email that should added to list
        $('#playerModal .invited_email').change(function(){
            $(this).val($.trim($(this).val()))
            $('#playerModal .invited_email').val($.trim($('#playerModal .invited_email').val()))

            $('#friends-list').children().each(function(i, el){

                if($(el).val()==$.trim($('#playerModal .invited_email').val())){

                    $('#playerModal .invited_name').val($(el).attr('text'))
                }
            })
        })

        //when pressed email add button
        $('#playerModal .add-friend-btn').click(function(){
            var email = $.trim($('#playerModal .invited_email').val())
            var name = $.trim($('#playerModal .invited_name').val())

            if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
                $('#playerModal .invited_email').focus().select()
                Swal.fire('Please insert valid email!', '','warning');
                return;
            }

            if(!name){
                $('#playerModal .invited_name').focus().select()
                Swal.fire('Please insert valid name!','', 'warning');
                return;
            }
            var duplicatedMessage = ''

            $('#playerModal .player-list li').each((i, el)=>{
                if($('span', el).attr('title')==email){
                    duplicatedMessage = email + ' is already invited as ' + $(el).text();
                }
            })

            if(duplicatedMessage){
                Swal.fire(duplicatedMessage, '', 'warning');
                return;
            }

            var html = '<li class="player-item mb-1">'+
                            '<span title="'+email+'">'+name+'</span>'+
                            '<a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a>'+
                            '<a href="javascript:;" class="ml-1 delete-trigger"><i class="nova-trash icon-text"></i></a>'+
                        '</li>';
            $('#playerModal .player-list').append(html);

            $('#playerModal .invited_email').val('')
            $('#playerModal .invited_name').val('')

        })

        //expire date picker
        $(".createbetblock #expire").flatpickr({
            disable: [{
                from: '0001-01-01',
                to: '{{date("Y-m-d", strtotime("-1 day"))}}'
            }]
        });

        // when pressed 'Create New Bet' button
        $(document).on('click', '.bet-create-btn', function(){
            $('.createbetblock #betinfoModal').modal()
        })

        //when pressed pencil edit button in bet modal(input box)
        $(document).on('click', '.createbetblock .bet-info-input .editor-trigger, .createbetblock .player-list .editor-trigger', function(){
            if ($('i', this).hasClass('nova-pencil')) {

                var txt = $.trim($(this).parent().children('span').text())
                var input = document.createElement('input')
                input.value = txt

                if ($(this).parent().get(0).tagName.toLowerCase() == 'li') {
                    input.style.width = ($(this).parent().parent().width() - 70) + 'px';
                } else {
                    input.style.width = ($(this).parent().parent().width() - 30) + 'px';
                }

                $(this)
                    .parent()
                    .children('span')
                    .html(input);

                $('i', this)
                    .removeClass('nova-pencil')
                    .addClass('nova-save')
            } else {
                var txt = $.trim($(this).parent().children('span').children('input').val())
                $(this)
                    .parent()
                    .children('span')
                    .html(txt);

                $('i', this)
                    .removeClass('nova-save')
                    .addClass('nova-pencil')
            }
        })

        //when pressed pencil edit button in bet modal(textarea box)
        $(document).on('click', '.createbetblock .bet-info-textarea .editor-trigger', function(){
            if ($('i', this).hasClass('nova-pencil')) {

                var txt = $.trim($(this).parent().children('span').text())
                var textarea = document.createElement('textarea')
                textarea.innerText = txt
                textarea.style.width = ($(this).parent().parent().width() - 30) + 'px';



                $(this)
                    .parent()
                    .children('span')
                    .html(textarea);

                $('i', this)
                    .removeClass('nova-pencil')
                    .addClass('nova-save')
            } else {
                var txt = $.trim($(this).parent().children('span').children('textarea').val())
                $(this)
                    .parent()
                    .children('span')
                    .html(txt);

                $('i', this)
                    .removeClass('nova-save')
                    .addClass('nova-pencil')
            }
        })

        //when pressed trush button in bet modal
        $(document).on('click', '.createbetblock .delete-trigger', function(){
            $(this).parent().remove()
        })

        //option add button
        $('.createbetblock .add-option-trigger').click(function() {
            var html = '<li class="bet-info-input mb-1">' +
                '<input type=radio name=options>' +
                '<span> New Option</span> ' +
                '<a href="javascript:;" class="ml-1 editor-trigger"><i class="nova-pencil icon-text"></i></a> ' +
                '<a href="javascript:;" class="ml-1 delete-trigger"><i class="nova-trash icon-text"></i></a>' +
                '</li>'

            $(this).prev().append(html)
        })

        //bet modal 'Next' button pressed then should open player modal
        $('.createbetblock .bet-modal-next').click(function() {

            if (!getVal('.createbetblock [_t="bet title"]', true)) {
                Swal.fire('Please input valid Bet Title', '', 'warning');
                return;
            }

            if (!getVal('.createbetblock [_t="bet description"]', true)) {
                Swal.fire('Please input valid Bet Description', '', 'warning');
                return;
            }

            if (!$('.createbetblock .bet-options li span').length) {
                Swal.fire('Please input one more bet options', '', 'warning');
                return;
            }

            var validOptions = true

            $('.createbetblock .bet-options li span').each(function(i, el) {
                if (!getVal(el, true)) {
                    validOptions = false
                }
            })

            if (false === validOptions) {
                Swal.fire('Please input valid option value', '', 'warning');
                return;
            }

            if (!$('.createbetblock #expire').val()) {

                Swal.fire('Please input valid expire date', '', 'warning');
                return;
            }


            // if (!$('.createbetblock .bet-options input[type=radio]:checked').length) {
            //     Swal.fire('Please choose correct answer', '', 'warning');
            //     return;
            // }

            $('.createbetblock #betinfoModal').modal('hide');
            $('.createbetblock #playerModal').modal('show');
        })

        //when pressed 'Back' button, should show bet modal
        $('.createbetblock .back-to-bet').click(function() {
            $('.createbetblock #playerModal').modal('hide')
            $('.createbetblock #betinfoModal').modal('show')
        })

        //bet create/save action
        $('.createbetblock .save-bet').click(function() {
            var data = getValidBetData();

            if(!data)return;

            $.LoadingOverlay("show")

            $.post(BASE_URL + '/adjudicator/save-bet', data, function(r) {
                $.LoadingOverlay("hide")
                Swal.fire('Successfully saved and Sent eamil to your friends.', '', 'success')
                    .then(() => {
                        location.href = BASE_URL + '/adjudicator';
                    })
            })

            $('.createbetblock #betinfoModal').modal('hide');
            $('.createbetblock #playerModal').modal('hide');
        })



        function getVal(selector, removeInput) {
            var val = ''

            if ($(selector).children('input').length) {
                val = $.trim($('input', selector).val())

                if (removeInput === true) {
                    removeInputs(selector)
                }
            } else if ($(selector).children('textarea').length) {

                val = $.trim($('textarea', selector).val())

                if (removeInput === true) {
                    removeInputs(selector)
                }
            } else {
                val = $.trim($(selector).text())
            }

            return val
        }

        function removeInputs(selector) {
            if ($(selector).children('input').length) {

                val = $.trim($('input', selector).val())
                $('input', selector).remove()
                $(selector).text(val)
            } else if ($(selector).children('textarea').length) {

                val = $.trim($('textarea', selector).val())
                $('textarea', selector).remove()
                $(selector).text(val)
            }
        }

        function getValidBetData(){

            if (!$('.createbetblock .player-item').length) {
                Swal.fire('Please choose one more player', '', 'warning');
                return;
            }

            var data = {
                id: $('.createbetblock .save-bet').attr('iid'),
                title: getVal('.createbetblock [_t="bet title"]'),
                description: getVal('.createbetblock [_t="bet description"]'),
                options: [],
                expire: $('.createbetblock #expire').val(),
                players: []
            }

            $('.createbetblock .bet-options li span').map((i, el) => {
                data.options.push({
                    txt: $(el).text(),
                    is_answer: $(el).parent().children('input[type=radio]').is(':checked') ? 1 : 0
                })
            })

            $('.createbetblock .player-item span').map((i, el) => {
                data.players.push({
                    email: $(el).attr('title'),
                    name: $(el).text()
                })
            })

            return data
        }
    })
</script>
