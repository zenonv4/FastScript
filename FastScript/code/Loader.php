<?php
require_once ('ext/htmldom.php');

class Loader {
	private $Loaded;
	//Boolean
	private $RawDom;
	private $WorkedDom;
	private $HtmlDom;

	private $Element;
	function __construct() {
		$this -> Loaded = false;
	}

	// Load simply load an given FastScript into an array
	public function Load($File) {
		$this -> Loaded = true;
		// Create DOM from URL or file
		$this -> RawDom = file_get_html($File . '/main.xml');
		$this -> WorkedDom = array('button' => array(), 'window' => array());
		// Find all root buttons
		foreach ($this->RawDom ->find('button') as $element) {
			
		}
		// Find all windows
		foreach ($this->RawDom ->find('window') as $element) {
			$TArr = array();
			//Temp array
			$TArr['Name'] = $element -> name;
			$TChild = array();
			foreach ($element->children as $e) {
				array_push($TChild, array('Type' => $e -> tag, 'postype' => $e -> postype, 'posy' => $e -> posy, 'posx' => $e -> posx, 'onclick' => $e -> onclick, 'Name' => $e -> innertext));
			}
			$TArr['Children'] = $TChild;

			array_push($this -> WorkedDom['window'], $TArr);
		}
		//Not working for now
		return $this -> WorkedDom;
	}

	// Work takes array from loads and makes it into an viable html document
	public function Work() {
		$this -> HtmlDom = $this -> HtmlDom . '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FastScript</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/res/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="/res/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/res/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/res/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/res/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/res/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
      <div class="container">

  ';
		//Code related to display
		$Tdom = $this->RawDom->find('fastscript');
		foreach ($Tdom[0]->children as $w) {
			switch($w->tag) {
				case 'window' :
					$this -> HtmlDom = $this -> HtmlDom . '<div class="well"><p>' . $w->name . '</p><hr>';
					foreach ($w->children as $c) {
						switch($c->tag) {
							case 'button' :
								$this -> HtmlDom = $this -> HtmlDom . '<button class="btn" onclick="' . $c->onclick . '"style="position:' . $c->postype . ';left:' . $c->posx . ';top:' . $c->posy . '">' . $c->innertext. '</button>';
								break;
							case 'input' :
								switch($c->type) {
									case 'textarea' :
										$this -> HtmlDom = $this -> HtmlDom . '<textarea class="input-xlarge" onclick="' . $c->onclick . '"style="position:' . $c->postype . ';left:' . $c->posx . ';top:' . $c->posy . '">' . $c->innertext . '</textarea>';

										break;
								}
								break;
						}
					}
					$this -> HtmlDom = $this -> HtmlDom . '</div>';
					break;

				//Handling windowless elements
				case 'button' :
					$this -> HtmlDom = $this -> HtmlDom . '<button class="btn" onclick="' . $w->onclick . '"style="position:' . $w->opostype . ';left:' . $w->posx . ';top:' . $w->posy . '">' . $w->innertext. '</button>';

					break;
			}

		}
		$this -> HtmlDom = $this -> HtmlDom . '
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/res/js/jquery.js"></script>
    <script src="/res/js/bootstrap-transition.js"></script>
    <script src="/res/js/bootstrap-alert.js"></script>
    <script src="/res/js/bootstrap-modal.js"></script>
    <script src="/res/js/bootstrap-dropdown.js"></script>
    <script src="/res/js/bootstrap-scrollspy.js"></script>
    <script src="/res/js/bootstrap-tab.js"></script>
    <script src="/res/js/bootstrap-tooltip.js"></script>
    <script src="/res/js/bootstrap-popover.js"></script>
    <script src="/res/js/bootstrap-button.js"></script>
    <script src="/res/js/bootstrap-collapse.js"></script>
    <script src="/res/js/bootstrap-carousel.js"></script>
    <script src="/res/js/bootstrap-typeahead.js"></script>

  </body>
</html>';
		return $this -> HtmlDom;
	}

}
?>
