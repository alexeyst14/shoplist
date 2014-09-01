$(function() {
    $(".editable").editable(function(value, settings) {
            id = $(this).attr('id').substr(5);
            $.ajax({
                url: URL_AJAX_SAVE_ITEM,
                method: 'post',
                data: {'status' : 0, 'id' : id, 'title' : value}
            });
            return value;
        },
        {
            submit    : "OK",
            style  : "inherit",
            width : '150px',
            submitdata : {action : 'edit'}
        }
    );

    // remove item
    $('body').on('click', '.remove_item', function() {
        id = $(this).parent().find('span').attr('id').substr(5);
        item = $(this).parent();
        title = item.find('span').text();
        $.ajax({
            url: URL_AJAX_SAVE_ITEM,
            method: 'post',
            data: {'status' : 1, 'id' : id, 'title' : title},
            success: function(json) {
                item.remove();
            }
        });
    });

    // Add new item
    $('#button_add').click(function() {
        $('#shop_list_form').append('<p class="item"><span id="item_" class="editable">New item</span> <a href="#" class="remove_item">[X]</a></p>');
        $(".editable").editable(function(value, settings) {
                item = this;
                $.ajax({
                    url: URL_AJAX_SAVE_ITEM,
                    method: 'post',
                    async: false,
                    data: {'status' : 0, 'id' : null, 'title' : value},
                    success: function(json) {
                        $(item).attr('id', 'item_' + json.id)
                    }
                });
                return value;
            },
            {
                submit    : "OK",
                style  : "inherit",
                width : '150px',
                submitdata : {action : 'add'}
            }
        );
    });

    worker();

});



(function worker() {
    $.ajax({
        url: URL_AJAX_REFRESH,
        data: {
            last_refresh : $('#last_refresh').val()
        },
        success: function(json) {
            $('#last_refresh').val(json.last_refresh);
            $(json.data).each(function(index, val) {
                if (val.status == '1') {
                    $('#item_' + val.id).parent().remove();
                } else {
                    $('#item_' + val.id).text(val.title);
                }

                if (!$('#item_' + val.id).length && val.status == 0) {
                    $('#shop_list_form').append('<p class="item"><span id="item_' + val.id + '" class="editable">' + val.title + '</span> <a href="#" class="remove_item">[X]</a></p>');
                }

            });
        },
        complete: function() {
            // Schedule the next request when the current one's complete
            setTimeout(worker, 5000);
        }
    });
})();