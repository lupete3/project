@extends('layouts.app')

@section('content')
    <livewire:quotes.quote-details :quote="$quote" />
@endsection