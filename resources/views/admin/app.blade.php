<!DOCTYPE html>
<!--                                     ____
                                         |  |
       _____  _  ___  ________  ______   |  |__     __   __
     / 	___/ | ' __/ |  ___  | /  _____\ |   _  \  |  | |  |
    |  |__   |  |    | |___| | \_____  \ |  |_)  | |  |_|  |
     \_____\ |__|    |_______| /_______/ |_'____/  _\___,  |
      https://github.com/alfredcrosby/ilearn      |_______/
 -->
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ $page_title or 'Home' }} | LMS SMK WIRA HARAPAN</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,400italic,600,600italic,700italic,800italic' rel='stylesheet' type='text/css'>
	<link href="{{ asset('assets/css/admin/build.min.css') }}" rel="stylesheet" type="text/css" />

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
  	<div class="wrapper">
			@include('admin.header')

			@include('admin.sidebar')

			<div class="content-wrapper">		
	        <section class="content-header">
	        	<h1>
	        		{{ $page_title or 'Beranda' }}
	        		<small>@yield('page_description')</small>
	        	</h1>
	        </section>
			<section class="content">
				@if (Session::has('flash_notification.message'))
		            <div class="alert alert-{{ Session::get('flash_notification.level') }}">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		                {{ Session::get('flash_notification.message') }}
		            </div>
			    @endif
				@yield('content')
			</section>
		</div>

		@include('admin.footer')
	</div><!-- ./wrapper -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
	<script src="{{ asset('assets/js/admin/build.min.js') }}" type="text/javascript"></script>
</body>
</html>