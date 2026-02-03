@extends('layouts.app')

@section('content')
    <livewire:invoices.invoice-details :invoice="$invoice" />
@endsection