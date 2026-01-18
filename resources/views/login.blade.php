<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background-color: #3e4d63;
    }

    main {
      flex: 1; /* pushes footer to the bottom */
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .card {
      background: rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 15px;
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      width: 100%;
      max-width: 400px;
      padding: 20px;
    }

    footer {
      text-align: center;
      color: white;
      padding: 10px 0;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <main>
    <div class="card">
        @if(session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-success mt-3">
                {{ session()->get('error') }}
            </div>
        @endif
        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                <li class="text-white">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <h4 class="text-center mb-4">Login</h4>
        <form action="{{ route('user.check') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email/Phone</label>
            <input type="text" class="form-control" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
  </main>

<footer>
  <div class="text-center">
    <img src="{{ asset('logo.jpg') }}" alt="Logo" style="height: 50px; margin-bottom: 8px;">
    <p style="font-size: 14px;">
      &copy; {{ date('Y') }} by <b>Pavan Tech Innovations</b>. All Rights Reserved.
    </p>
  </div>
</footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
