<?php

  function store_screenshots( $id, $gallery ) {

    foreach( $gallery AS $g ) {
      $filename = md5( $id . '-' . microtime() . basename( $g ) ) . '.' . pathinfo( basename( $g ), PATHINFO_EXTENSION );

      if( copy( $g, STORAGE_SCREENSHOTS . $filename ) ) {
        return true;
      } else {
        return false;
      }

    }

  }

  function store_thumbnail( $id, $url ) {

    $filename = md5( '1-' . microtime() . basename( $url ) ) . '.' . pathinfo( basename( $url ), PATHINFO_EXTENSION );

    if( copy( $url, STORAGE_THUMBNAILS . $filename ) ) {}

  }

  function store_file( $id, $file ) {

    $name = md5( date( 'Y-m-d H:i:s:u' ) ) . '-' . str_replace( 'filename%3D', '', strstr( $file, 'filename%3' ) );
    file_put_contents( STORAGE_FILES . $name, fopen( $file, 'r' ) );
    $size = filesize( STORAGE_FILES . $name );

    rename( STORAGE_FILES . $name, STORAGE_FILES . $name );

  }
