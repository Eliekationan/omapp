<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('images/logo.png   ') }}">
    
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('css/homePage.css')}}">
        <!-- Styles -->
        
    </head>
    <body class="">
        <div class="container" style="">
            <nav class="navbar navbar-expand-lg" class="text-center">
                <div class="logo-zone d-flex align-items-center">
                    <img width="50" src="images/logo.png" alt="" srcset="">
                    {{-- <h2 class="enterprise-name" style="margin-left:14px; color: #B3F0E9;">Organization Manager</h2> --}}
                  </div>
                <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
                >
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                    <a
                        style="color:#4E4E68"
                        class="nav-link dropdown-toggle text-uppercase"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Produits
                    </a>
                    <ul class="dropdown-menu" style="width: 200% !important">
                        <li><a class="dropdown-item" href="#">Logiciel de gestion d'organisation</a></li>
                        <li><a class="dropdown-item" href="#">Site E-commerce</a></li>
                    </ul>
                    </li>
                    <li class="nav-item dropdown">
                    <a
                        style="color:#4E4E68"
                        class="nav-link dropdown-toggle text-uppercase"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Utilisations
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        
                    </ul>
                    </li>
                    <div class="mr-2">
                        <button class="btn login-btn" style="">Se connecter</button>
                    </div>
                    <div class="">
                        <button class="btn sign-up-btn" style="">S'enregistrer</button>
                    </div>
                </ul>
                
                </div>
                
            </nav>
        </div>
    </body>
    <style>
        .navbar-toggler-icon {
            color: white !important;
        }
        li{
            width: 150px
        }
        ul{
            width: 150% !important;
        }
        .login-btn, .sign-up-btn{
            border: 2px solid #4E4E68
        }
        .navbar-nav{
            padding:2%; 
        }
        @media screen and (max-width:990px){
            .navbar-nav{
                width: 100% !important;
                background-color: lightblue;
                border: solid 1px #4E4E68
            }
        }
    </style>
</html>
