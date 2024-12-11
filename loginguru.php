<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guru</title>
    <link rel="icon" type="image/png" href="assets/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<a class="back-button" href="pilihlogin.php">← Kembali</a>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Login Guru</h3>
                    <form method="POST" action="proses_login_guru.php">
                        <div class="mb-3">
                            <label for="user" class="form-label">Username atau Email</label>
                            <input type="text" name="user" id="user" class="form-control" placeholder="Masukkan username atau email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
