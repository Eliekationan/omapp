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
            <nav class="navbar d-md-flex justify-content-between navbar-expand-lg px-4" class="text-center px-2" style="position:sticky; top:0;">
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-2 rounded">
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
                        <a class="btn login-btn" style="" href="{{route('home')}}">Se connecter</a  >
                    </div>
                    <div class="">
                        <button class="btn sign-up-btn" style="">S'enregistrer</button>
                    </div>
                </ul>
                </div>
            </nav>

            <div class="card-body">
                <div class="row mb-4 mt-4">
                    <div class="col-12 col-md-6">
                        <img src="{{ asset('images/roadmap.png') }}" alt="RoadMap">
                    </div>
                    <div class="col-12 col-md-6 p-4">
                        <div class="title text-center mb-4">Application ideale pour votre organisation</div>
                        <div class="content">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                            orem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                        </div>
                    </div>
                </div>
                <div class="row mb-4 mt-4">
                    <div class="col-12 col-md-6 p-4">
                        <div class="title text-center mb-4">Gestion des utilisateurs et leurs rôles</div>
                        <div class="content">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                            orem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                        </div>
                    </div>
                    <div class="col-12 col-md-6  d-md-flex justify-content-center">
                        <img src="{{ asset('images/users.png') }}" alt="RoadMap">
                    </div>
                </div>
                <div class="row mb-2 mt-4">
                    <div class="col-12 col-md-6 d-md-flex justify-content-center">
                        <img src="{{ asset('images/gestion_projet.jpg') }}" alt="RoadMap">
                    </div>
                    <div class="col-12 col-md-6 p-4">
                        <div class="title text-center mb-4">Gestion des adhésion</div>
                        <div class="content">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                            orem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                        </div>
                    </div>
                </div>
                <div class="row mb-2 mt-4">
                    <div class="col-12 col-md-6 p-4">
                        <div class="title text-center mb-4">Gestion des cotisations</div>
                        <div class="content">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                            orem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-md-flex justify-content-center">
                        <img src="{{ asset('images/gestion_projet.jpg') }}" alt="RoadMap">
                    </div>
                </div>
                <div class="row mb-2 mt-4">
                    <div class="col-12 col-md-6 d-md-flex justify-content-center">
                        <img src="{{ asset('images/gestion_projet.jpg') }}" alt="RoadMap">
                    </div>
                    <div class="col-12 col-md-6 p-4">
                        <div class="title text-center mb-4">Gestion des projets</div>
                        <div class="content">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                            orem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus, nesciunt aut? Sapiente cupiditate aut eligendi tempora cum quisquam, odio debitis veritatis ipsum, possimus incidunt hic soluta adipisci temporibus voluptatum repudiandae.
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="footer p-4">
            <div class="d-md-flex justify-content-between align-items-center">
                <div class="">APPLICATION DE GESTIONS D'ORGANISATION</div>
                <div class="" style="font-size:16px">By OMAPP</div>
            </div>
        </div>
    </body>
    <style>
        body{
            background-color: white !important;
        }
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
        nav{
            background-color:lightblue;
        }
        @media screen and (max-width:990px){
            .navbar-nav{
                width: 100% !important;
                background-color: lightblue;
                border: solid 1px #4E4E68
            }
                nav{
                background-color:white;
            }
        }
        .title{
            font-family: cursive, Georgia, 'Times New Roman', Times, serif;
            font-size: 25px;
        }
        .footer{
            background-color: #4E4E68;
            height: 50px;
            color: white;
            /* font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif */
        }
    </style>
</html>
