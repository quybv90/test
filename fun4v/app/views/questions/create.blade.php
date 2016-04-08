@extends('layouts.visitor')
@section('content')
<form>
<h1>Create New Question</h1>
<div class="form-group">
    <input name="title" type="text" placeholder="Title?" class="form-control"/>
</div>
<textarea id="some-textarea" name="content" data-provide="markdown" rows="15"></textarea>
<hr/>
<button type="submit" class="btn btn-success">Submit</button>
</form> 
@stop
