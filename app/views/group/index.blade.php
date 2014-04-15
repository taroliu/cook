@extends("layout")
@section("content")
	@if(count($groups))
		<table>
			<tr>
				<th>name</th>
				<th>$nbsp;</th>
			@foreach($groups as $group)
			<tr>
				<td>{{$group->name}}</td>
				<td><a href="{{ URL::route("group/edit") }}?id={{$group->id}}">edit</a>  <a href="{{ URL::route("group/delete") }}?id={{ $group->id}}" class="confirm" data-confirm="Are you sure you want to delete this group?">delete</a></td>
			</tr>
			@endforeach
		</table>
	@else
	<p>There are no groups.</p>
	@endif
		<a href="{{URL::route("group/add")}}">add group</a>
@stop
@section("footer")
@parent
	<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="/js/layout.js"></script>
@stop