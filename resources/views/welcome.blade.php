<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
       
    </head>
    <body>
	<div>
		<main class="container">
			<div class="container" >
				<div class="row justify-content-center">
					<div class="col-md-8" id="app">
					<h1>Search Videos</h1>
						<router-view></router-view>
					</div>
				</div>
			</div>
		</main>
    </div>
        <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
