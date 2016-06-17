<?php

  /**
  *** Initiate Envato API
  **/

  include 'vendor/autoload.php';
  include 'config.php';

  $url = 'http://themeforest.net/item/metrika-bootstrap-material-admin-dashboard/16329460?s_rank=1';

  // Initiate scraper
  $scraper = new \Smafe\EnvatoScraper( array(
    'api_id' => ENVATO_ID
  , 'api_secret' => ENVATO_SECRET
  , 'api_redirect' => ENVATO_REDIRECT
  , 'api_token' => ENVATO_PERSONAL_TOKEN
  , 'storage' => '/home/hello'
  ) );


  // Fetch screenshots
  try {

    $screenshots = $scraper->fetch_screenshots( $url );

  } catch( \ErrorException $e ) {

    $screenshots = $e->getMessage();

  }


  // Fetch meta
  try {

    $meta = $scraper->fetch_meta( '16329460' );

  } catch( \ErrorException $e ) {

    $meta = $e->getMessage();

  }


  // Fetch file
  try {

    $file = $scraper->fetch_file( '16329460' );

  } catch( \ErrorException $e ) {

    $file = $e->getMessage();

  }


  // Fetch thumbnail
  try {

    $thumbnail = $scraper->fetch_thumbnail( '16329460' );

  } catch( \ErrorException $e ) {

    $thumbnail = $e->getMessage();

  }


  // Fetch comments
  try {

    $comments_start = microtime( true );
    $comments = $scraper->fetch_comments( '16329460' );
    $comments_total = microtime( true ) - $comments_start;

  } catch( \ErrorException $e ) {

    $comments = $e->getMessage();

  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Envato PHP API library to easily connect and communicate with the Rest API.">
    <meta name="author" content="Smafe Web Solutions">

    <title>Smafe - Envato PHP Marketplaces Scraper</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
      h3 {
        margin-top: 50px;
      }

      .container {
        max-width: 760px;
      }
    </style>
  </head>

  <body>

    <div class="container">

      <div class="page-header">
        <h1>Envato PHP Marketplaces Scraper</h1>
        <p class="lead">Simple PHP library to connect and communicate with the Envato API.</p>
      </div>

      <h2>Dependencies</h2>
      <p>This library depends on a few other libraries to function correctly. These library assist with connecting to the Envato API as well as scraping content from the Envato marketplaces.</p>

      <ul>
        <li><a href="https://github.com/sunra/php-simple-html-dom-parser" target="_blank">sunra/php-simple-html-dom-parser</a> is used to scrape content from the Envato marketplaces</li>
        <li><a href="https://github.com/smafe-com/envato-api-library" target="_blank">smafe/envato-api</a> is used to connect to the Envato API and gather useful data</li>
      </ul>

      <p>By using composer then these libraries are auto-installed / required.</p>

      <section id="initiate">
        <h3>Initiate the library</h3>
        <p>It's easy to connect to the Envato API by first <a href="https://build.envato.com/" target="_blank">creating an application or private token with Envato</a>. The information given can be provided like the example below to utilize the powerful Rest API.</p>

        <pre>$scraper = new \Smafe\EnvatoScraper( array(
  'api_id' => ENVATO_ID
, 'api_secret' => ENVATO_SECRET
, 'api_redirect' => ENVATO_REDIRECT
, 'api_token' => ENVATO_PERSONAL_TOKEN
, 'storage' => '/home/hello'
) );</pre>


        <h3 class="text-danger">fetch_screenshots( <code>$url, $save = false</code> )</h3>
        <p>You can fetch all the screenshots from an item in any of the marketplaces by providing a URL to the webpage.</p>

        <div>
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#screenshots_markup" aria-controls="home" role="tab" data-toggle="tab">Markup</a></li>
            <li role="presentation"><a href="#screenshots_result" aria-controls="profile" role="tab" data-toggle="tab">Result</a></li>
          </ul>

          <br />

          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="screenshots_markup">
              <pre>// Get array with screenshots
$screenshots = $scraper->fetch_screenshots( '16329460' );

// Store screenshots to server
$screenshots = $scraper->fetch_screenshots( '16329460', true );
</pre>
            </div>

            <div role="tabpanel" class="tab-pane" id="screenshots_result">
              <pre><?php print_r( $screenshots ); ?></pre>
            </div>
          </div>
        </div>

        <br />

        <code>$id</code>
        <p><small>Provide an Envato item ID to fetch the screenshots from.</small></p>

        <br />

        <code>$save</code>
        <p><small>If you want to save the requested data somehow. Set it to <i>true</i> to store the screenshots or <i>false</i> to just return the URL's. <strong>Requires</strong> that you create the function <code>store_screenshots( $id, $request );</code> somewhere in your code.</small></p>
      </section>

      <section id="fetch-meta">
        <h3 class="text-danger">fetch_meta( <code>$url, $save = false</code> )</h3>
        <p>Fetch the latest meta data from the server, return it and or store it.</p>

        <div>
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#meta_markup" aria-controls="home" role="tab" data-toggle="tab">Markup</a></li>
            <li role="presentation"><a href="#meta_result" aria-controls="profile" role="tab" data-toggle="tab">Result</a></li>
          </ul>

          <br />

          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="meta_markup">
              <pre>// Fetch meta data
$thumbnail = $scraper->fetch_thumbnail( '16329460' );

// Store screenshots to server
$thumbnail = $scraper->fetch_thumbnail( '16329460', true );
</pre>
            </div>

            <div role="tabpanel" class="tab-pane" id="meta_result">
              <pre><?php print_r( $meta ); ?></pre>
            </div>
          </div>

          <br />

          <code>$id</code>
          <p><small>Provide an Envato item ID to fetch the meta data from.</small></p>

          <br />

          <code>$save</code>
          <p><small>If you want to save the requested data somehow. Set it to <i>true</i> to store the meta data or <i>false</i> to just return the array with data. <strong>Requires</strong> that you create the function <code>store_meta( $id, $request );</code> somewhere in your code.</small></p>

        </div>
      </section>

      <section id="fetch_comments">
        <h3 class="text-danger">fetch_comments( <code>$url</code> )</h3>
        <p>Fetch all the comments for a specific item and return it in a nested PHP array for you to manipulate and use in your own code.</p>

        <div>
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#comments_markup" aria-controls="home" role="tab" data-toggle="tab">Markup</a></li>
            <li role="presentation"><a href="#comments_result" aria-controls="profile" role="tab" data-toggle="tab">Result</a></li>
          </ul>

          <br />

          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="comments_markup">
              <pre>// Get array with comments
$comments = $scraper->fetch_comments( '16329460' );

// Store comments
$comments = $scraper->fetch_comments( '16329460', true );
</pre>
            </div>

            <div role="tabpanel" class="tab-pane" id="comments_result">
              <pre><?php print_r( $comments ); ?></pre>
            </div>
          </div>

          <p>It took <strong><?php echo $comments_total; ?></strong> seconds to execute this command finding <strong><?php echo count( $comments ); ?></strong> comments.</p>

          <br />

          <code>$id</code>
          <p><small>Provide an Envato item ID you want to fetch all the items from.</small></p>

          <br />

          <code>$save</code>
          <p><small>If you want to save the requested data somehow. Set it to <i>true</i> to store the meta data or <i>false</i> to just return the array with data. <strong>Requires</strong> that you create the function <code>store_comments( $id, $comments );</code> somewhere in your code.</small></p>

        </div>
      </section>

      <section id="fetch_thumbnail">

        <h3 class="text-danger">fetch_thumbnail( <code>$url, $save = false</code> )</h3>
        <p>Fetch the thumbnail from Envato and store it if you want.</p>

        <div>
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#thumbnail_markup" aria-controls="home" role="tab" data-toggle="tab">Markup</a></li>
            <li role="presentation"><a href="#thumbnail_result" aria-controls="profile" role="tab" data-toggle="tab">Result</a></li>
          </ul>

          <br />

          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="thumbnail_markup">
              <pre>// Get thumbnail
$thumbnail = $scraper->fetch_thumbnail( '16329460' );

// Store thumbnail
$thumbnail = $scraper->fetch_thumbnail( '16329460', true );
</pre>
            </div>

            <div role="tabpanel" class="tab-pane" id="thumbnail_result">
              <pre><?php print_r( $thumbnail ); ?></pre>
            </div>
          </div>

          <br />

          <code>$id</code>
          <p><small>Provide an Envato item ID you want to fetch the thumbnail from.</small></p>

          <br />

          <code>$save</code>
          <p><small>If you want to save the requested data somehow. Set it to <i>true</i> to store the meta data or <i>false</i> to just return the array with data. <strong>Requires</strong> that you create the function <code>store_thumbnail( $id, $comments );</code> somewhere in your code.</small></p>

        </div>

      </section>

      <section id="fetch_file">

        <h3 class="text-danger">fetch_file( <code>$url, $save = false</code> )</h3>
        <p>You can fetch all the screenshots from an item in any of the marketplaces by providing a URL to the webpage.</p>

        <div>
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#file_markup" aria-controls="home" role="tab" data-toggle="tab">Markup</a></li>
            <li role="presentation"><a href="#file_result" aria-controls="profile" role="tab" data-toggle="tab">Result</a></li>
          </ul>

          <br />

          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="file_markup">
              <pre>$url = 'http://themeforest.net/item/metrika-bootstrap-material-admin-dashboard/16329460?s_rank=1';
                $storage_path = '/home/project/public/data/screenshots/';

                // Get array with screenshots
                $thumbnail = $scraper->fetch_thumbnail( $url );

                // Store screenshots to server
                $thumbnail = $scraper->fetch_thumbnail( $url, $storage_path );
              </pre>
            </div>

            <div role="tabpanel" class="tab-pane" id="file_result">
              <pre><?php print_r( $file );  ?></pre>
            </div>
          </div>
        </div>

        <p>It is recommended that you store the access token and re-use it using <code>setAccessToken()</code> so you avoid generating new tokens for every visit.</p>
      </section>

      <h3>Working example</h3>
      <p>This is a complete working example using the Envato API that should work out of the box :)</p>

      <pre>$envato = new \Smafe\Envato( array(
  'api_id' => 'ENVATO APP ID'
, 'api_secret' => 'ENVATO SECRET KEY'
, 'api_redirect' => 'APP REDIRECT URI'
, 'api_token' => 'APP TOKEN'
) );

$request = $envato->request( 'v3/market/catalog/item?id=13041404' );

print_r( $request );</pre>

      <br />
      <br />
      <br />

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Piwik -->
    <script type="text/javascript">
      var _paq = _paq || [];
      _paq.push(["setDomains", ["*.envato-api.demo.smafe.com"]]);
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function() {
        var u="//t.smafe.com/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', 11]);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
      })();
    </script>
    <noscript><p><img src="//t.smafe.com/piwik.php?idsite=11" style="border:0;" alt="" /></p></noscript>
    <!-- End Piwik Code -->

  </body>
</html>
