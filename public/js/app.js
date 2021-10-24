$(function () {
    $('#add-player-btn').click(function () {
        $.ajax({
            method: "POST",
            url: URL + 'match/addPlayer',
            data: {
                name: $('#player-name').val(),
                match_id: $('#matchId').val()
            }
        })
            .done(function (result) {
                if (result.content) {
                    location.reload();
                } else {
                    alert("Can't added, please check your name.");
                }
            })
            .fail(function () {
                alert("Can't added, please check your name.");
            })
    });

    $('.remove-player').click(function () {
        let playerLine = $(this).parent().parent();
        let participantCount = $('.participant-count').html();
        $.ajax({
            method: "POST",
            url: URL + 'match/removePlayer',
            data: {
                player_id: $(this).data('id'),
                match_id: $('#matchId').val()
            }
        })
            .done(function (res) {
                if (res.content) {
                    playerLine.remove();
                    $('.participant-count').html(participantCount - 1);
                } else {
                    alert("Can't removed, please check your name.");
                }
            })
            .fail(function () {
                alert("Can't removed.");
            })
    });

    $('#update-settings-btn').click(function () {
        $.ajax({
            method: "POST",
            url: URL + 'match/updateMatch',
            data: {
                player_id: $(this).data('id'),
                match_title: $('#match_title').val(),
                match_location: $('#match_location').val(),
                match_date: $('#match_date').val(),
                match_id: $('#matchId').val()
            }
        })
            .done(function (res) {
                if (res.content.result) {
                    $('#exampleModal').modal('hide');
                    $('.match_title').text(res.content.data.match_title);
                    $('.match_date').text(res.content.data.match_date);
                } else {
                    alert("Error while updating...");
                }
            })
            .fail(function () {
                alert("Error while updating...");
            })
    });
});
