<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg p-4" style="max-width: 800px; width: 100%;">
            <h1 class="text-center mb-4">Register</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender:</label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="linkedin_username" class="form-label">LinkedIn Username:</label>
                    <input type="text" id="linkedin_username" name="linkedin_username" class="form-control" value="{{ old('linkedin_username') }}" required>
                </div>

                <div class="mb-3">
                    <label for="hobby" class="form-label">Hobbies:</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="basketball" id="hobbyBasketball">
                        <label class="form-check-label" for="hobbyBasketball">Basketball</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="soccer" id="hobbySoccer">
                        <label class="form-check-label" for="hobbySoccer">Soccer</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="running" id="hobbyRunning">
                        <label class="form-check-label" for="hobbyRunning">Running</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="tech" id="hobbyTech">
                        <label class="form-check-label" for="hobbyTech">Tech</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="drawing" id="hobbyDrawing">
                        <label class="form-check-label" for="hobbyDrawing">Drawing</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="chess" id="hobbyChess">
                        <label class="form-check-label" for="hobbyChess">Chess</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="volleyball" id="hobbyVolleyball">
                        <label class="form-check-label" for="hobbyVolleyball">Volleyball</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="studying" id="hobbyStudying">
                        <label class="form-check-label" for="hobbyStudying">Studying</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="writing" id="hobbyWriting">
                        <label class="form-check-label" for="hobbyWriting">Writing</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="hobby[]" value="reading" id="hobbyReading">
                        <label class="form-check-label" for="hobbyReading">Reading</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="mobile_number" class="form-label">Mobile Number:</label>
                    <input type="text" id="mobile_number" name="mobile_number" class="form-control" value="{{ old('mobile_number') }}" required>
                </div>

                <div class="mb-3">
                    <label for="age" class="form-label">Age:</label>
                    <input type="text" id="age" name="age" class="form-control" value="{{ old('age') }}" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>

                <div class="text-center">
                    <p class="mb-0">Already have an account? <a href="{{ url('/login') }}">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
