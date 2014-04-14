@extends("layout")
@section("content")
	@if(count($groups))
		<table>
			<tr>
				<th>name</th>
		
			@foreach($groups as $group)
			<tr>
				<td>{{$group->name}}</td>
			</tr>
			@endforeach
		</table>
	@else
	<p>There are no groups.</p>
	@endif
		<a href="{{URL::route("group/index")}}">add group</a>
@stop