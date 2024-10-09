<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verifikasi Email</div>
                    <div class="card-body">
                        <p>Silakan klik link berikut untuk verifikasi email Anda:</p>
                        <a href="{{ $verificationUrl }}" class="btn btn-primary">Verifikasi Email</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
