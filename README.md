# Premiere League Simulation

Go Demo: [https://premierleague.akcauser.com/](https://premierleague.akcauser.com/)

## Tech Stack

* PHP (version: 8.0)
* Laravel (version: 8.5)
* MySQL (version: 8.0) (Persistent Storage)
* Nginx
* Docker, Docker Compose
* Github Actions

## Installation

**Note:** If you do not have docker daemon, install and run before.

1. Clone the repo

```shell
git clone https://github.com/akcauser/Premiere-League-Simulation.git
```

2. Change directory to `Premiere-League-Simulation`

```shell
cd Premiere-League-Simulation
```

3. Copy `.env.example` file as `.env` and add your environment variables

```shell
cp .env.example .env
```

4. Install vendor

```shell
composer install
```

5. Generate app key

```shell
php artisan key:generate
```

6. Build And Run Docker Containers

```shell
docker-compose up -d
```

6. Wait 1 minute :blush: and enter to app container

```shell
docker exec -it premiere-league-simulation_app_1 bash
```

7. Migrate and seed database in container.

```shell
php artisan migrate:fresh --seed
```

8. Open welcome page [http://localhost:8080](http://localhost:8080)

![welcome image](./doc/img/welcome.png)

# Tests

Run this command to run tests.

```shell
php artisan test
```

# Screenshots

* Fixture Page
  
![fixture screenshot](./doc/img/fixture.png)

* Simulation Page

![welcome image](./doc/img/simulation.png)

# Algorithms

#### Number of goals scored by one team to against team
Algorithm looks past matches and goal difference. Also, it uses random integers.

```
goal = 0
coefficient = x won match - x lost match - against won match + against lost match + x goal difference
if coefficient > 0
  goal = goal + random_int(0, coefficient % 3)

goal = goal + random_int(0, random_int(1,6))
```

### Prediction Algorithm

```

if remainingWeekNumber*3 < firstTeamPoint - $secondTeamPoint or remainingWeekNumber = 0 then [firstTeamPrediction = 100%]

if first_team_point - x team point > remainingWeekNumber*3 then [x team prediction = 0%]

**Calculation**

**X** Team Prediction = 100 / (total won match + (if goal_difference > 0 then goal_difference / 7 else 0 for all teams)) * (**X** won match + (if goal_difference > 0 then goal_difference / 7 else 0 for **X** team))

```
# Contributing Guide

* [Check Contributing Guide](./CONTRIBUTING.md).
