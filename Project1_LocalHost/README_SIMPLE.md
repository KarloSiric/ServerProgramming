# SIMPLE MVC PROJECT

## Structure:
```
Project1/
├── Index.php              # Entry point
├── app/
│   ├── controller/
│   │   ├── Controller.php    # Base controller
│   │   └── UserController.php # User controller
│   ├── model/
│   │   ├── Model.php         # Base model
│   │   └── UserModel.php     # User model
│   ├── view/
│   │   ├── inc/
│   │   │   ├── header.php
│   │   │   └── footer.php
│   │   └── user/
│   │       ├── login.php
│   │       └── welcome.php
│   └── router/
│       └── Router.php
└── public/
    └── css/
        └── style.css
```

## Test Users:
- Username: `kmarasovic` Password: `1234`
- Username: `jane` Password: `4321`

## How to Run:
1. Using XAMPP/WAMP: Access `http://localhost/Project1/`
2. Using PHP server: `php -S localhost:9000` then go to `http://localhost:9000/`

## Routes:
- `/` or `/Index.php` - Shows login
- `/user/welcome` - After login (POST only)
