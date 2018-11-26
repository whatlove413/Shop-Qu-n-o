$(document).ready(function() {

    // leftBar
        var $child = $(".leftBarChild");
        $child.each( function( i ) {
            
            var $item = $(this);
            if( $item.attr('parent') )
            {

                var $parent = $item.closest("#leftBarParent");
                // var child = $item.text();
                // var parent = $parent.find(".title").eq(0).text();
                $parent.addClass("active open");
                $("#page_layout").text( $item.text() );
                return false; 
            }
        } ); 
    // end leftBar

    // Thông báo lỗi
        if( $("#msgAdmin").length > 0 )
        {

            var $this = $("#msgAdmin");
            $.bootstrapGrowl( $this.val() ,{ 
                type: $this.attr('type-msg'), 
                delay: $this.attr('time-msg'),
                align: 'left',
            });
        };
    // End thông báo lỗi
} );