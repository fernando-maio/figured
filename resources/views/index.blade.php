<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Figured - Inventory</title>
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="{{ asset('images/logo.jpg') }}" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-apply" method="POST" action="{{ route('apply') }}">
                @csrf
                <input type="number" min="1" id="input_apply" name="input_apply" class="form-control" placeholder="Quantity" required autofocus>
                <button class="btn btn-lg btn-primary btn-block btn-apply" type="submit">Apply</button>
            </form>
        </div>

        @if (!empty($inventory))
            <div class="alert alert-success">
                {{ __('Total Amount: ') . $inventory }}
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br />
                @endforeach
            </div>
        @endif
    </div>
</body>

</html>
