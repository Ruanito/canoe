# Canoe Tech Assessment

## Install the application

Steps to create the project in the local environment

### Install dependencies

`$ compose install`

### Create .env

`$ cp .env.example .env`

### Start docker

`$ docker-compose up`

### Start project

`$ php artisan serve`

Now the application is running on http://127.0.0.1:8000

## Project endpoints

### Create Funds

`POST /api/funds`

Request payload:

```
{
    "name": "Fund Name",
    "start_year": 2023,
    "fund_manager": {
        "name": "Fund Manager Name"
    },
    "alias_funds": [
        {
            "name": "Alias Name"
        },
        {
            "name": "Alias Name 2"
        }
    ]
}
```

Response payload:
```
{
    "status": "success",
    "fund": {
        "name": "Fund Name",
        "start_year": 2023,
        "fund_manager_id": 1,
        "updated_at": "2023-07-16T15:07:30.000000Z",
        "created_at": "2023-07-16T15:07:30.000000Z",
        "id": 1
    }
}
```

### List Funds

`GET /api/funds?name=Fund Name&year=2023&fund_manager=Fund Manager Named`

Response payload:
```
{
    "status": "success",
    "funds": [
        {
            "id": 1,
            "name": "Fund Name",
            "start_year": "2023",
            "fund_manager": "Fund Manager Name"
        }
    ]
}
```

### Update fund

`PUT /api/funds/:id`

Response payload:
```
{
    "status": "success"
}
```

### Duplicated fund

`GET /api/funds-duplicated`

Response payload:

```
{
    "status": "success",
    "funds": [
        {
            "id": 2,
            "fund_name": "Alias Name",
            "fund_manager": "Fund Manager Name"
        }
    ]
}
```

## DB Diagram
https://dbdiagram.io/d/64af396602bd1c4a5efb6633


### Tips

#### Refresh database

Run in console

`$ php artisan migrate:fresh`

#### Logs

You can validate the events in the logs

```
[2023-07-16 19:30:10] local.DEBUG: Start VerifyDuplicatedFund  
[2023-07-16 19:30:10] local.DEBUG: Fund id=1  
[2023-07-16 19:30:10] local.DEBUG: Duplicated funds: []  
[2023-07-16 19:30:27] local.DEBUG: Start VerifyDuplicatedFund  
[2023-07-16 19:30:27] local.DEBUG: Fund id=2  
[2023-07-16 19:30:27] local.DEBUG: Process DuplicateFundWarning FundId=2  
[2023-07-16 19:30:27] local.DEBUG: TODO  
[2023-07-16 19:30:27] local.DEBUG: Duplicated funds: [{"id":1,"name":"Fund Name","start_year":"1981","fund_manager_id":1,"created_at":"2023-07-16 19:30:10","updated_at":"2023-07-16 19:30:10"}]  

```
