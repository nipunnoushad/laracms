<script>
    /* Check All Input checknox */
    $(document).on('click', '#checkAll',function() {
        $('input.checkItem:checkbox').not(this).prop('checked', this.checked);
    });

    $('input[type="checkbox"].route_name').on('click', function() {
        let getFor = $(this).prop('id');
        //alert(getFor)
        if ($(this).is(':checked')) {
            $('.' + getFor + '_show_as').show();
            $('.' + getFor + '_show_as input[type="radio"]').prop('required', true);
        } else {
            $('.' + getFor + '_show_as input[type="radio"]').prop('required', false);
            $('.' + getFor + '_show_as').hide();
        }
    })
    $('label.route_name').on('click', function() {
        let getFor = $(this).prop('for');
        if ($(this).is(':checked')) {
            $('.' + getFor + '_show_as input[type="radio"]').prop('required', true);
            $('.' + getFor + '_show_as').show();
        } else {
            $('.' + getFor + '_show_as input[type="radio"]').prop('required', false);
            $('input.' + getFor + '_show_as').hide();
        }
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" async></script>
