<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="asset/css/bootstrap.css" rel="stylesheet">

    <title>Simulation</title>
</head>
<body>
<div class="m-3">
    <div class="text-center mt-2">
        <h1>Simulation</h1>
    </div>
    <div class="row mt-3">
        <div class="col-6">
            <table class="table">
                <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">Team Name</th>
                    <th scope="col">PTS</th>
                    <th scope="col">P</th>
                    <th scope="col">W</th>
                    <th scope="col">D</th>
                    <th scope="col">L</th>
                    <th scope="col">GD</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pointTable as $row)
                    <tr>
                        <th scope="col">{{ $row["team"] }}</th>
                        <th scope="col">{{ $row["pts"] }}</th>
                        <th scope="col">{{ $row["p"] }}</th>
                        <th scope="col">{{ $row["w"] }}</th>
                        <th scope="col">{{ $row["d"] }}</th>
                        <th scope="col">{{ $row["l"] }}</th>
                        <th scope="col">{{ $row["gd"] }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-3">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dark text-white pt-2"><b>Week {{ $lastWeekGames[0]->week }}</b></li>
                <li class="list-group-item pt-3 pb-3 text-center">
                    <div class="row">
                        <div class="col">{{ $lastWeekGames[0]->team_1 }}</div>
                        @if($lastWeekGames[0]->played)
                            <div class="col">{{ $lastWeekGames[0]->score_1 }} - {{ $lastWeekGames[0]->score_2 }}</div>
                        @else
                            <div class="col">-</div>
                        @endif
                        <div class="col">{{ $lastWeekGames[0]->team_2 }}</div>
                    </div>
                </li>
                <li class="list-group-item pt-2 text-center">
                    <div class="row">
                        <div class="col">{{ $lastWeekGames[1]->team_1 }}</div>
                        @if($lastWeekGames[1]->played)
                            <div class="col">{{ $lastWeekGames[1]->score_1 }} - {{ $lastWeekGames[1]->score_2 }}</div>
                        @else
                            <div class="col">-</div>
                        @endif
                        <div class="col">{{ $lastWeekGames[1]->team_2 }}</div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-3">
            <table class="table">
                <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">Championship Predictions</th>
                    <th scope="col">%</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="col">Liverpool</th>
                    <th scope="col">0</th>
                </tr>
                <tr>
                    <th scope="col">Manchester City</th>
                    <th scope="col">0</th>
                </tr>
                <tr>
                    <th scope="col">Chelsea</th>
                    <th scope="col">0</th>
                </tr>
                <tr>
                    <th scope="col">Arsenal</th>
                    <th scope="col">0</th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="m-1 text-center">
        <div class="row">
            @if($lastWeekGames[0]->week != 6)
                <div class="col">
                    <a href="{{ route('simulation.playAll') }}" class="btn btn-info">Play All Weeks</a>
                </div>
                <div class="col">
                    <a href="{{ route('simulation.play') }}" class="btn btn-info">Play Next Week</a>
                </div>
            @endif
            <div class="col">
                <a href="{{ route('simulation.reset') }}" class="btn btn-danger">Reset Data</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
