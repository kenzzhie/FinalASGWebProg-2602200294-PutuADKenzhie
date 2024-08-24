<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handle Overpayment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Overpayment</h1>
                    </div>
                    <div class="card-body">
                        <p class="text-center">Sorry, you overpaid <strong>${{ number_format($amount, 2) }}</strong>.</p>
                        <p class="text-center">Would you like to add the balance to your wallet?</p>

                        <form method="POST" action="{{ route('process.overpayment') }}">
                            @csrf

                            <!-- Hidden Inputs -->
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="payment_amount" value="{{ $payment_amount }}">
                            <input type="hidden" name="price" value="{{ $price }}">

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <button type="submit" name="action" value="accept" class="btn btn-success">Yes, add to wallet</button>
                                <button type="submit" name="action" value="decline" class="btn btn-danger">No, correct amount</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional if you're using Bootstrap JS components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
