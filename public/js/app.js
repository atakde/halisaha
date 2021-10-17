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
                    location.reload();
                } else {
                    alert("Can't added, please check your name.");
                }
            })
            .fail(function () {
                alert("Can't deleted.");
            })
    });
});
