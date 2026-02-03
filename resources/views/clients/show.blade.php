@extends('layouts.app')

@section('content')
    <livewire:clients.client-details :client="$client" />
@endsection