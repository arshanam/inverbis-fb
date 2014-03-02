<?php
/**
 * Desenvolvido por Ricardo Pinto <@ricard0pinto>
 */

require 'src/facebook.php';

// liga a instância da app com a api e chave

$facebook = new Facebook(array(
  'appId'  => '',
  'secret' => '',
));

// apresenta o ID do utilizador com método GET
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl();
}
//amigos teus que estão a rede TIC e Sociedade
if ($user) {
	$amigos_comuns_rede = $facebook->api(array(
	'method' => 'fql.query',
	'query' => 'SELECT uid, name FROM user WHERE uid IN(SELECT uid2 FROM friend WHERE uid1 = me()) AND is_app_user = 1'
	));
} else {
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl();
}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
  	<meta charset="UTF-8" />
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Rede Tic e Sociedade</title>
    <link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/elementos.css" />
	<link rel="stylesheet" type="text/css" href="css/app.css" />
	<link rel="stylesheet" type="text/css" href="css/icones.css" />
	<link rel="stylesheet" type="text/css" href="css/base.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
	<script src="js/modernizr.custom.js"></script>
	<script src="js/jquery.easing.1.3.min.js"></script>
	<script src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.reveal.js"></script>
	<script src="js/jquery.fitvids.js"></script>
	<script src="js/base.js"></script>
  </head>
  <body>
  	<script type="text/javascript">
	document.write("<div id='sitePreloader'><div id='preloaderImage'><img src='imagens/site_preloader.gif' alt='Preloader' /></div></div>");
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_PT/all.js#xfbml=1&appId=679953708684464";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  	<div class="area">
  		<header class="ticsociedade-header">
  			<div id="logoTicSociedade">
  			<h1>Rede TIC e Sociedade<span>criar, conhecer, crescer...</span></h1>
  			</div>
  			<div class="direto">
  				<iframe width="560" height="315" src="//www.youtube.com/embed/kFcSBfYcRF0" frameborder="0" allowfullscreen></iframe>
  				<p>Não consegue visualizar a transmissão? <a href="#" class="big-link partilha" data-reveal-id="caixaModal">Veja como resolver!</a></p>
  				<div id="caixaModal" class="reveal-modal">
					<h2>Desabilite a segurança nesta página</h2>
					<p>As definições do seu browser não permitem a visualização do conteúdo, veja na imagem abaixo como resolver.</p>
					<img src="imagens/desativar-prot.gif" alt="desativar proteção de página" />
					<a class="close-reveal-modal">&#215;</a>
				</div>	
  			</div>
    <hr />
    </header>
		<div class="interior">
			<div id="inicio">
					<div class="caixa-comentarios">
						<div class="fb-comments" data-href="http://www.ticsociedade.pt/app/" data-colorscheme="dark" data-numposts="10" data-width="560"></div>
					</div>
    <nav id="bt-menu" class="bt-menu">
				<a href="#" title="Menu" class="bt-menu-trigger">Menu</a>
				<ul>
					<li><a href="index.php" id="inicioPag" title="Transmissão em direto" class="bt-icon fa-video-camera">inicio</a></li>
					<li><a href="debate.php" title="Comentários" class="bt-icon fa-comments-o">comentários</a></li>
					<li><a href="painel-convidados.php" title="Programa" id="programaPag" class="bt-icon fa-bullhorn">programa</a></li>
					<li><a href="album.php" id="eventosPag" title="Fotografias" class="bt-icon fa-picture-o">eventos</a></li>
					<li><a href="questionario.php" id="eventosPag" title="Questionário" class="bt-icon fa-question-circle">questionário</a></li>
					<li><a href="https://www.ticsociedade.pt" target="_blank"  title="Website" id="arquivoPag" class="bt-icon fa-external-link">Rede TIC e Sociedade</a></li>
				</ul>
			</nav>
	</div>
</div>
	    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>',
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/pt_PT/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
  </body>
  <script src="js/classie.js"></script>
  <script src="js/menu.js"></script>
</html>
