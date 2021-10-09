<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="asset/css/bootstrap.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>

    <title>Simulation</title>
</head>
<body>
<div class="m-3" id="app">
    <div class="text-center mt-2">
        <h1>Simulation</h1>
    </div>
    <div class="row mt-3">
        <div class="col-6">
            <table class="table">
                <thead>
                <tr class="bg-dark text-white">
                    <th scope="col" title="Team Name">Team Name</th>
                    <th scope="col" title="Point">PTS</th>
                    <th scope="col" title="Played">P</th>
                    <th scope="col" title="Won">W</th>
                    <th scope="col" title="Drawn">D</th>
                    <th scope="col" title="Lost">L</th>
                    <th scope="col" title="Goals For">GF</th>
                    <th scope="col" title="Goals Against">GA</th>
                    <th scope="col" title="Goal Difference">GD</th>
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
                        <th scope="col">{{ $row["gf"] }}</th>
                        <th scope="col">{{ $row["ga"] }}</th>
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
                @foreach($predictions as $team => $percent)
                <tr>
                    <th scope="col">{{ $team }}</th>
                    <th scope="col">{{ $lastWeekGames[0]->week >= 3 ? $percent : "-" }}</th>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="m-1 text-center">
        <div class="row">
            @if($lastWeekGames[0]->week != 6)
                <div class="col">
                    <a :class="{'disabled' :btnClicked}" @click="playAllMatches()" class="btn btn-info">Play All Weeks</a>
                </div>
                <div class="col">
                    <a :class="{'disabled' :btnClicked}" @click="playMatch()" class="btn btn-info">Play Next Week</a>
                </div>
            @endif
            <div class="col">
                <a :class="{'disabled' :btnClicked}" @click="reset()" class="btn btn-danger">Reset Data</a>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-6">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dark text-white pt-2"><b>Played Matches</b></li>
                <li class="list-group-item pt-3 pb-3 text-center">
                    @foreach($playedGames as $game)
                    <div class="row">
                        <div class="col text-danger">Week {{ $game->week }}</div>
                        <div class="col">{{ $game->team_1 }}</div>
                        @if($game->played)
                            <div class="col">{{ $game->score_1 }} - {{ $game->score_2 }}</div>
                        @else
                            <div class="col">-</div>
                        @endif
                        <div class="col">{{ $game->team_2 }}</div>
                    </div>
                    @endforeach
                </li>
            </ul>
        </div>
    </div>
</div>
</body>

<script>
    const app = new Vue({
        el: '#app',
        delimiters: ['!{', '}!'],
        data() {
            return {
                title: "Generated Fixtures",
                teams: null,
                clicked: false,
            }
        },
        methods: {
            playMatch(){
                this.clicked = true
                window.location.href = "{{ route('simulation.play') }}"
            },
            playAllMatches(){
                this.clicked = true
                window.location.href = "{{ route('simulation.playAll') }}"
            },
            reset(){
                this.clicked = true
                window.location.href = "{{ route('simulation.reset') }}"
            },
        },
        computed: {
            btnClicked(){
                return this.clicked;
            }
        }
    });
</script>

</html>
