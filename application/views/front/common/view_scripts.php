    <script src="<?php echo base_url() . CONST_PATH_ASSETS_FRONT_SCRIPTS;?>jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    
    <script type="text/javascript">
        $(document).ready(function () {
            $('#country_id').on('change', function () {
                var countryID = $(this).val();
                if (countryID!=0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ?>auth/ajaxData',
                        data: 'country_id=' + countryID,
                        success: function (html) {
                           // alert(html);
                            $('#state_id').html(html);
                            $('#city_id').html('<option value="0">Select state first</option>');
                        }
                    });
                } else {
                    $('#state_id').html('<option value="0">Select country first</option>');
                    $('#city_id').html('<option value="0">Select state first</option>');
                }
            });

            $('#state_id').on('change', function () {
                var stateID = $(this).val();
                if (stateID!=0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ?>auth/ajaxData',
                        data: 'state_id=' + stateID,
                        success: function (html) {
                            $('#city_id').html(html);
                        }
                    });
                } else {
                    $('#city_id').html('<option value="0">Select state first</option>');
                }
            });
        });

    </script>