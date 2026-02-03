@extends('layouts.app')

@section('content')
    <livewire:invoices.invoice-form :invoice="$invoice" />
@endsection