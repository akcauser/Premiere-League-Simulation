<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="asset/css/bootstrap.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>

    <title>Create New Tournament</title>
</head>
<body>
    <div class="container mt-5" id="app">
        <ul class="list-group list-group-flush">
            <li class="list-group-item pt-2 font-weight-light"><h4>Tournament Teams</h4></li>
            <li class="list-group-item bg-dark text-white pt-2"><b>Team Name</b></li>
            @foreach($teams as $team)
                <li class="list-group-item pt-2">{{ $team->name }}</li>
            @endforeach
        </ul>
        <div class="mt-2">
            <a href="{{ route('fixture.generate') }}" class="btn btn-info">
                Generate Fixtures
            </a>
        </div>
    </div>
</body>

<script>
</script>
</html>
