<!DOCTYPE html>
<html <?php language_attributes() ?>>
	<head>
		<meta charset="<?php bloginfo('charset') ?>"
		<title><?php wp_title('-', true, 'right'); bloginfo() ?></title>

		<!-- StyleSheets -->
		<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/estilo.css" />
	</head>
	<body <?php body_class() ?>>

		<!-- cabeçalho -->	 
		<header class="header">
			<hgroup>
				<h1><a href="<?php bloginfo('url') ?>"><?php bloginfo() ?></a></h1>
				<h2><?php bloginfo('description') ?></h2>
			</hgroup>
		</header>
		<!-- fim cabeçalho -->