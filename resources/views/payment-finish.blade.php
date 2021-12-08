{{-- https://857a-36-72-212-156.ngrok.io/payment_success?order_id=VUKNLW5AFI&status_code=201&transaction_status=pending --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Payment Finish</title>
</head>
<body>
  @if($transaction)
    <h1>Payment Detail</h1>
    <h2>Status Order: {{ $transaction->status }}</h2>
    <h2>Order ID: {{ $transaction->transaction_code }}</h2>
  @else
    <h1>Invalid Order</h1>
  @endif
</body>
</html>