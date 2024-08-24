<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Payment Form</h1>
                    </div>
                    <div class="card-body">

                        <!-- Display the price -->
                        <h5 class="text-center mb-4">Amount Due: <strong>{{ $price }}</strong></h5>

                        <!-- Success message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Error message -->
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Payment form -->
                        <form method="POST" action="{{ route('updatePaid') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="payment_amount" class="form-label">Enter Payment Amount:</label>
                                <input type="number" class="form-control" id="payment_amount" name="payment_amount" required>
                            </div>

                            <!-- Hidden input for price -->
                            <input type="hidden" id="price" name="price" value="{{ $price }}">

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary w-100">Pay Now</button>
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
