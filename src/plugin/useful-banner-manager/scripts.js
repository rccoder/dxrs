jQuery( document ).ready( function( $ ) {
    $.each( $( '.useful_banner_manager_banners_rotation' ), function() {
        if ( $( this ).find( '.useful_banner_manager_rotating_banner' ).length > 1 ) {
            var banners_rotation_block = $( this );
            var interval = 1000 + $( this ).data( 'interval' );

            setTimeout( function() { useful_banner_manager_rotate_banners( banners_rotation_block, interval ) }, interval );
        }
    } );

} );

function useful_banner_manager_rotate_banners( banners_rotation_block, interval ) {
    jQuery ( function( $ ) {
        $.each( $( banners_rotation_block ).find( '.useful_banner_manager_rotating_banner' ), function() {
            if ( $( this ).css( 'display' ) != 'none' ) {
                if ( $( this ).next().html() != null ) {
                    $( this ).fadeOut( 1000, function() {
                        var next_banner_id = $( this ).next().data( 'banner-id' );

                        $( this ).next().fadeIn( 1000 );
                    } );
                } else {
                    $( banners_rotation_block ).find( '.useful_banner_manager_rotating_banner:last' ).fadeOut( 1000, function() {
                        var next_banner_id = $( banners_rotation_block ).find( '.useful_banner_manager_rotating_banner:first' ).data( 'banner-id' );

                        $( banners_rotation_block ).find( '.useful_banner_manager_rotating_banner:first' ).fadeIn( 1000 );
                    } );
                }
            }
        } );
    } );

    setTimeout( function() { useful_banner_manager_rotate_banners( banners_rotation_block, interval ) }, interval );
} 