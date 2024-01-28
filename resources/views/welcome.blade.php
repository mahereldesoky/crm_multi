@extends('layouts.app')
@section('content')


<div class="container">
    
 @if (session('message'))
 <div class="alert alert-success" role="alert">
     {{ session('message') }}
 </div>
@endif


<h1>ananannan hamamda</h1>

<form action="{{ url('/subdomain') }}" method="post">
@csrf

<label for="">Enter Company Name</label>
<input type="text" name="subdomain" id="subdomain" >

<label for="">name</label>
<input type="text" name="name" id="subdomain" >

<label for="">email</label>
<input type="text" name="email" id="subdomain" >

<label for="">password</label>
<input type="text" name="password" id="subdomain" >

<button type="submit">submit</button>

</form>



<table>
<thead>
<tr width="50%">
 <td width="60%">Tenant Name</td>
 <td width="50%">Tenant domain</td>
</tr>
</thead>
<tbody>
@foreach ($tenants as $tenant)
 
<tr>
 <td>{{ $tenant->id }}</td>
 @foreach ( $tenant->domains as $domain){
     <td>{{ $domain->domain }}</td>
 }    
@endforeach

</tr>
@endforeach

</tbody>
</table>


<form action="{{ url('/login') }}" method="post">
@csrf

<label for="">email</label>
<input type="text" name="email" id="subdomain" >

<label for="">password</label>
<input type="text" name="password" id="subdomain" >

<button type="submit">submit</button>

</form>

</div>


@endsection
