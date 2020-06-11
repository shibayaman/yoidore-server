<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    </head>
    <body>
       <div>
            <form action="/api/auth/login" method="post">
                <input type="text" name="username" >
                <input type="password" name="password" >
                <input type="submit" value="login" >
            </form>
            <a href="/api/auth/user">get User</a>
            <form action="/api/auth/logout" method="post">
                <input type="submit" value="logout">
            </form>
       </div>
    </body>
</html>
