<?php

  namespace Smafe;

  class EnvatoScraper {

    /**
    *** Construct authentication details
    **/

    public function __construct( $data ) {

      if( isset( $data['api_id'] ) )
        $this->api_id = $data['api_id'];

      if( isset( $data['api_secret'] ) )
        $this->api_secret = $data['api_secret'];

      if( isset( $data['api_redirect'] ) )
        $this->api_redirect = $data['api_redirect'];

      if( isset( $data['api_token'] ) )
        $this->api_token = $data['api_token'];

      if( isset( $data['api_refresh_token'] ) )
        $this->api_refresh_token = $data['api_refresh_token'];

    }


    /**
    *** Multiple Screenshots
    **/

    public function multiple_screenshots( $url ) {

      $html = \Sunra\PhpSimple\HtmlDomParser::file_get_html( $url );
      $gallery = array();

      if( ( $html->find( '.screenshots', 0 ) ) ) {

        if( ( $html->find( '.-preview-live', 0 ) ) AND ( $html->find( '.-preview-live a.is-hidden' ) ) ) {
          foreach( $html->find( '.-preview-live a.is-hidden' ) AS $s ) {
            $gallery[] = $s->href;
          }
        } elseif( ( $html->find( '.-preview-live', 0 ) ) AND ( $html->find( '.-preview-live img', 0 ) ) ) {
          $s = $html->find( '.-preview-live img', 0 );
          $gallery[] = $s->src;
        } elseif( ( $html->find( '.item-preview-image__gallery', 0 ) ) ) {
          foreach( $html->find( '.item-preview-image__gallery a.is-hidden, .item-preview a.is-hidden' ) AS $s ) {
            $gallery[] = $s->href;
          }
        }

      } else {

        return false;

      }

      return $gallery;

    }


    /**
    *** Single Screenshot
    **/

    public function single_screenshot( $url ) {

      $html = \Sunra\PhpSimple\HtmlDomParser::file_get_html( $url );
      $gallery = array();

      if( ( $file = $html->find( '.item-preview img', 0 )->src ) )
        $gallery[] = $file;

      else
        return false;

      return $gallery;

    }


    /**
    *** Fetch File
    **/

    function fetch_file( $id, $save = false ) {

      $envato = new \Smafe\Envato( array(
        'api_id' => $this->api_id
      , 'api_secret' => $this->api_secret
      , 'api_redirect' => $this->api_redirect
      , 'api_token' => $this->api_token
      ) );

      $file = $envato->request( 'v3/market/buyer/download', 'GET', array( 'item_id' => $id ) );

      if( $file->download_url ) {

        return $file;

      } else {

        return false;

      }

    }


    /**
    *** Fetch Screenshots
    **/

    public function fetch_screenshots( $url, $save = false ) {

      // Multiple screenshots
      if( $multiple = self::multiple_screenshots( $url ) )
        $gallery = $multiple;

      // Single screenshot
      elseif( $single = self::single_screenshot( $url ) )
        $gallery = $single;

      if( $save )
        $this->store_screenshots( $url, $gallery );

      return $gallery;

    }


    /**
    *** Fetch Meta
    **/

    function fetch_meta( $id, $save = false ) {

      $envato = new \Smafe\Envato( array(
        'api_id' => $this->api_id
      , 'api_secret' => $this->api_secret
      , 'api_redirect' => $this->api_redirect
      , 'api_token' => $this->api_token
      ) );

      $request = $envato->request( 'v3/market/catalog/item', 'GET', array( 'id' => $id ) );

      if( $save AND !$request->error AND function_exists( store_meta() ) )
        store_meta( $id, $request );

      return $request;

    }


    /**
    *** Fetch Thumbnail
    **/

    function fetch_thumbnail( $id, $save = false ) {

      $envato = new \Smafe\Envato( array(
        'api_id' => $this->api_id
      , 'api_secret' => $this->api_secret
      , 'api_redirect' => $this->api_redirect
      , 'api_token' => $this->api_token
      ) );

      $request = $envato->request( 'v3/market/catalog/item', 'GET', array( 'id' => $id ) );

      if( $request->previews->icon_preview->icon_url ) {

        if( $save AND function_exists( store_thumbnail() ) )
          store_thumbnail( $id, $request->previews->icon_preview->icon_url );

        return $request->previews->icon_preview->icon_url;

      } else {

        return false;

      }

    }


    /**
    *** Fetch Comments
    **/

    public function fetch_comments( $id, $page = 1, $comments = array(), $d_i = 0 ) {

      $envato = new \Smafe\Envato( array(
        'api_id' => $this->api_id
      , 'api_secret' => $this->api_secret
      , 'api_redirect' => $this->api_redirect
      , 'api_token' => $this->api_token
      ) );

      $request = $envato->request( 'v3/market/catalog/item', 'GET', array( 'id' => $id ) );
      $html = \Sunra\PhpSimple\HtmlDomParser::file_get_html( $request->url . '/comments?page=' . $page );

      if( $html->find( 'div[data-view=commentList]', 0 ) ) {

        // Foreach discussion
        foreach( $html->find( '.js-discussion' ) AS $d ) {

          // First comment
          $comments[$d_i]['id'] = explode( '_', $d->find( '.comment__item .comment__info', 0 )->id )[1];
          $comments[$d_i]['author']['name'] = $d->find( '.comment__item .comment__info .t-link', 0 )->innertext;
          $comments[$d_i]['author']['url'] = $d->find( '.comment__item .comment__info .t-link', 0 )->href;
          $comments[$d_i]['author']['creator'] = ( $d->find( '.comment__item .comment__info .e-text-label', 0 ) ) ? 1 : 0;
          $comments[$d_i]['comment'] = htmlspecialchars( $d->find( '.comment__item .js-comment__body', 0 )->innertext );

          $r_i = 0;

          // Responses
          foreach( $d->find( '.comment__item-response' ) AS $r ) {

            $comments[$d_i]['responses'][$r_i]['id'] = explode( '_', $r->find( '.comment__info', 0 )->id )[1];
            $comments[$d_i]['responses'][$r_i]['author']['name'] = $r->find( '.comment__info .t-link', 0 )->innertext;
            $comments[$d_i]['responses'][$r_i]['author']['url'] = $r->find( '.comment__info .t-link', 0 )->href;
            $comments[$d_i]['responses'][$r_i]['author']['creator'] = ( $r->find( '.comment__info .e-text-label', 0 ) ) ? 1 : 0;
            $comments[$d_i]['responses'][$r_i]['comment'] = htmlspecialchars( $r->find( '.js-comment__body', 0 )->innertext );

            $r_i++;

          }

          $d_i++;

        }

      }

      // Check if there is more pages
      if( $html->find( '.pagination__next', 0 ) ) {
        $html->clear();
        $comments = self::fetch_comments( $id, ++$page, $comments, $d_i );
      }

      $html->clear();
      return $comments;

    }

  }
