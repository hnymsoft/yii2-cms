$('i.glyphicon-refresh-animate').hide();
function updateItems(r) {
    _opts.items.available = r.available;
    _opts.items.assigned = r.assigned;
    search('available');
    search('assigned');
}

$('.btn-assign').click(function () {
    var $this = $(this);
    var target = $this.data('target');
    var items = $('select.list[data-target="' + target + '"]').val();

    if (items && items.length) {
        $this.children('i.glyphicon-refresh-animate').show();
        $.post($this.attr('href'), {items: items}, function (r) {
            updateItems(r);
        }).always(function () {
            $this.children('i.glyphicon-refresh-animate').hide();
        });
    }
    return false;
});

$('.search[data-target]').keyup(function () {
    search($(this).data('target'));
});

function search(target) {
    var $list = $('select.list[data-target="' + target + '"]');
    $list.html('');
    var q = $('.search[data-target="' + target + '"]').val();

    var groups = {
        role: [$('<optgroup label="角色">'), false],
        permission: [$('<optgroup label="权限">'), false],
        route: [$('<optgroup label="路由">'), false],
    };
    $.each(_opts.items[target], function (name, group) {
        if (name.indexOf(q) >= 0) {
            $('<option>').text(group[1]).val(name).appendTo(groups[group[0]][0]);
            groups[group[0]][1] = true;
        }
    });
    $.each(groups, function () {
        if (this[1]) {
            $list.append(this[0]);
        }
    });
}

// initial
search('available');
search('assigned');
