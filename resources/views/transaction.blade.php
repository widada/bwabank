@extends('base')

@section('title', 'Transaction')

@section('header_title', 'Transaction')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-body table-responsive p-0">
            <table id="transactions" class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Transaction Type</th>
                  <th>Payment Method</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Description</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($transactions as $transaction)
                  <tr>
                    <td>{{ $transaction->user->id }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->transactionType->code }}</td>
                    <td>{{ $transaction->paymentMethod->name }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ $transaction->updated_at }}</td>
                    <td>{{ $transaction->description }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
    <script>
      $('#transactions').DataTable();
    </script>
@endsection