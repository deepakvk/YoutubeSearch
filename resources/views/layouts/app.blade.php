<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<style lang="scss">
		.card {
		  .card-title a {
			color: #212529;
			&:hover {
			  text-decoration: none;
			  border-bottom: 2px solid #212529;
			}
		  }
		  margin: 0px 5px 5px 0px;
		  .card-img-top {
			max-height: 210px;
		  }
		}
		.iframe-container{
			position: relative;
			width:100%;
			padding-bottom:56.25%;
			height:0;
		}
		.iframe-container iframe{
			position: absolute;
			top:0;
			left:0;
			width:100%;
			height:100%;
		}
		</style>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
       
    </head>
    <body>
		
		<main id="app">
		@yield('content')			
		</main>
    
        <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
