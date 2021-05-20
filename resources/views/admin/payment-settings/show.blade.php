@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Show payment Method
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payment-settings.index') }}">
                    back to list
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $paymentMethod->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            method
                        </th>
                        <td>
                            {{ $paymentMethod->method }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            status
                        </th>
                        <td>
                            {{ $paymentMethod->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            description
                        </th>
                        <td>
                            {{ $paymentMethod->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            in enable
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $paymentMethod->in_enable ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payment-settings.index') }}">
                    back to list
                </a>
            </div>
        </div>
    </div>
</div>



@endsection