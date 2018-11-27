<script type="text/javascript">
    var input = $('#autocomplete');
    var options = {};
    var vehicle = <?php echo json_encode($data); ?>;
    input.autocomplete('disable');
    input.autocomplete('setOptions', options);
    input.autocomplete({
        lookup: vehicle,
        onSelect: function (suggestion) {
            //function khi select
        }
    });
</script>