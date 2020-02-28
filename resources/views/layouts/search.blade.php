@section('search')
	<div class="Search__wrapper">
		<div class="container">
			<form name="searchForm" method="POST" action="{{ route('youtube.search') }}">
			 {{csrf_field() }}
			
				Search: <input name="search" placeholder="Search Youtube Videos" value="{{$old_search ?? ''}}" type="text" class="form-control">
			</form>
		</div>
	</div>
@endsection	
