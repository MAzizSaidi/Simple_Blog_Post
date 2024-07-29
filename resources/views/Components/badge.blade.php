@if(!isset($show)|| $show)
<span class="alert alert-{{$type ?? 'success'}}">
    {{$slot}}
</span>
@endif
