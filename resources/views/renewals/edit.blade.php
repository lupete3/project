@extends('layouts.app')

@section('content')
    <livewire:renewals.renewal-form :renewal="$renewal" />
@endsection