<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="asset/css/bootstrap.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>

    <title>Generated Fixtures</title>
</head>
<body>
<div id="app" class="m-3">
    <div class="text-center mt-2">
        <h1>Generated Fixtures</h1>
    </div>
    <div class="row mt-3">
        @foreach($fixture as $week => $matches)
            <div class="col-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-dark text-white pt-2"><b>{{ $week }}</b></li>
                    <li class="list-group-item pt-3 pb-3 text-center">
                        <div class="row">
                            <div class="col">!{ teams[{!! $matches[0][0]-1 !!}] }!</div>
                            <div class="col-1">-</div>
                            <div class="col">!{ teams[{!! $matches[0][1]-1 !!}] }!</div>
                        </div>
                    </li>
                    <li class="list-group-item pt-2 text-center">
                        <div class="row">
                            <div class="col">!{ teams[{!! $matches[1][0]-1 !!}] }!</div>
                            <div class="col-1">-</div>
                            <div class="col">!{ teams[{!! $matches[1][1]-1 !!}] }!</div>
                        </div>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
    <div class="row m-1">
        <a href="{{ route('simulation') }}" class="btn btn-info">Start Simulation</a>
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
            }
        },
        methods: {},
        created(){
            if(localStorage.getItem('teams') == null){
                window.location.href = "{!! route('welcome') !!}"
            }
            this.teams = localStorage.getItem('teams').split(",")
        }
    });
</script>

</html>
