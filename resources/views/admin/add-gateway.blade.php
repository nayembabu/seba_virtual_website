@extends('layouts.admin')
@section('title')
 @lang('Add Gateway')
@endsection
@section('content')
 <div class= card card-primary m-0 m-md-4 my-4 m-md-0 shadow>
 <div class=card-body>
 <form action= method=post enctype=multipart/form-data>
 @if (->any())
 @foreach (->all() as )
 <div class=alert alert-danger>{{ }}</div>
 @endforeach
 @endif
 @csrf
 <div class=form-group>
 <label>Name <span class=req>*</span></label>
 <input type=text name=name class=form-control required />
 </div>
 <div class=form-group>
 <label>Account Number <span class=req>*</span></label>
 <input type=text name=account class=form-control required />
 </div>
 <div class=form-group>
 <label>Logo <span class=req>*</span></label>
 <input type=file name=logo class=form-control required />
 </div>
 <div class=form-group>
 <label>Status</label>
 <select name=status class=form-control>
 <option value=1>Active</option>
 <option value=0>Inactive</option>
 </select>
 </div>
 <div class=form-group>
 <label>Extra Details</label>
 <textarea name=details rows=7 class=form-control></textarea>
 </div>
 <div class=form-group>
 <button class=btn btn-success id=sbtn>Add</button>
 </div>
 </form>
 </div>
 </div>
@endsection
