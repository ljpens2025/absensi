<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.4.0
* @link https://tabler.io
* Copyright 2018-2026 The Tabler Authors
* Copyright 2018-2026 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->

<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />

	<title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>

	<link rel="icon" href="./favicon-dev.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="./favicon-dev.ico" type="image/x-icon" />

	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="{{asset('tabler/css/jsvectormap.css?1768453605')}}" rel="stylesheet" />
	<!-- END PAGE LEVEL STYLES -->

	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="{{asset('tabler/css/tabler.css?1768453605')}}" rel="stylesheet" />
	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- BEGIN PLUGINS STYLES -->
	<link href="{{asset('tabler/css/tabler-flags.css?1768453605')}}" rel="stylesheet" />
	<link href="{{asset('tabler/css/tabler-socials.css?1768453605')}}" rel="stylesheet" />
	<link href="{{asset('tabler/css/tabler-payments.css?1768453605')}}" rel="stylesheet" />
	<link href="{{asset('tabler/css/tabler-vendors.css?1768453605')}}" rel="stylesheet" />
	<link href="{{asset('tabler/css/tabler-marketing.css?1768453605')}}" rel="stylesheet" />
	<link href="{{asset('tabler/css/tabler-themes.css?1768453605')}}" rel="stylesheet" />
	<!-- END PLUGINS STYLES -->

	<!-- BEGIN DEMO STYLES -->
	<link href="{{asset('tabler/css/demo.css?1768453605')}}" rel="stylesheet" />
	<!-- END DEMO STYLES -->

	<!-- BEGIN CUSTOM FONT -->
	<style>
		@import url('https://rsms.me/inter/inter.css');
	</style>
	<!-- END CUSTOM FONT -->
	<script type="module" integrity="sha512-I1nWw2KfQnK/t/zOlALFhLrZA1yzsCzBl7DxamXdg/QF7kq+O4sYBZLl0DFCE7vP2ixPccL/k0/oqvhyDB73zQ==" src="/.11ty/reload-client.js"></script>
</head>

<body>
	<a href="#content" class="visually-hidden skip-link">Skip to main content</a>

	<!-- BEGIN GLOBAL THEME SCRIPT -->
	<script src="{{asset('tabler/js/tabler-theme.js')}}"></script>
	<!-- END GLOBAL THEME SCRIPT -->
	<div class="page">

		<!--  BEGIN SIDEBAR  -->
		@include('layout.admin.sidebar')
		<!--  END SIDEBAR  -->
		<!-- BEGIN NAVBAR  -->
		@include('layout.admin.header')
		<!-- END NAVBAR  -->
		<div class="page-wrapper">
			@yield('content')
			@include('layout.admin.footer')
		</div>
	</div>
	
	<!-- BEGIN PAGE LIBRARIES -->
	<script src="{{asset('tabler/js/apexcharts.min.js')}}" defer></script>
	<script src="{{asset('tabler/js/jsvectormap.min.js')}}" defer></script>
	<script src="{{asset('tabler/js/world.js')}}" defer></script>
	<script src="{{asset('tabler/js/world-merc.js')}}" defer></script>
	<!-- END PAGE LIBRARIES -->

	<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
	<script src="{{asset('tabler/js/tabler.js')}}" defer></script>
	<!-- END GLOBAL MANDATORY SCRIPTS -->

	<!-- BEGIN DEMO SCRIPTS -->
	<script src="{{asset('tabler/js/demo.js')}}" defer></script>
	<!-- END DEMO SCRIPTS -->

	<!-- BEGIN PAGE SCRIPTS -->
	<style>
		:root {
			--chart-visitors-color-0: color-mix(in srgb, transparent, var(--tblr-primary) 100%);
			--chart-visitors-color-1: color-mix(in srgb, transparent, var(--tblr-gray-400) 100%);
		}
	</style>
	
</body>

</html>