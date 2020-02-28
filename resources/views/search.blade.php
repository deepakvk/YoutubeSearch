@extends('layouts.app')
@include('layouts.search')

@section('content')

	<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8">					
					<h1>Search Videos</h1>
					<!--<router-view></router-view>-->
						<div class="YoutubeDash__wrapper">
							@yield('search')

							
							<div class="VideoGroup__wrapper row grid" style="position: relative;">
								@foreach($results as $result)
								<div class="VideoItem__wrapper clearfix">
									<div class="card" style="width: 15rem;">
										
										<div class="embed-responsive embed-responsive-16by9 mb-3">
										@if(isset($result->id->videoId))
											<youtube video-id="{{$result->id->videoId}}" ref="youtube" src="https://www.youtube.com/embed/"></youtube>
										@elseif(isset($result->id->channelId))
											<youtube video-id="{{$result->id->channelId}}" ref="youtube" src="https://www.youtube.com/embed/"></youtube>
										@endif	
										</div>
										</a> 
										<div class="card-body">
											<h5 class="card-title">
											
												{!! Str::limit($result->snippet->title, 50, ' ...') !!}
											</h5> 
											<p class="card-text">{!! Str::limit($result->snippet->description, 100, ' ...') !!}</p>																				  
										</div>
									</div>
							    </div>
							    
								@endforeach
							</div>						
						</div>
					</div>
				</div>
	</div>
@endsection