<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Clever') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a href="/">
                <img src="data:image/webp;base64,UklGRmwKAABXRUJQVlA4TF8KAAAvx8AVEKUoaNvISfiTvvmDQUT/08QjJuEJj/gLt7b2hsn+81DmigUoOS5zztm+JOmXLAYwkLYtTvczbNs2DP//uO1mQblt29i2X322m237H7AxKdlOto1oJNv+vmhH28Zm5LaNI91mK7fvGyQ5biNI0v//vIsAumzZWZXXXURQwLbtmKI9M9mNsm271tlY27btbP3OrXNr27th98/m2LmZB4IbSYqkzN1jcC3O9OwLwP/jS42dXf7zRrdRo0b8VOuaQLRCQXTKqB6dT/Vq4hUzGXtr9KQSkHwJBocD1RrdI88TJGeP8IrJovqwwBjW5rFEC2mcRZBLGg3CUkLfFdpM76FQVAV7rY2ZPOFRnWWUDG4HKqpiHu5hit4qvG6arHYcM37IEXHyka3qzQ9KrVJYAEBba3DIjKESjiaHypC0BIMJTk0KbZzHPKzBABtVeGI2lphbk1Tx2H4k2IuNUZ9zAMXXoJAUU0UdTQ6VANcTwqkmRQT+Yh6ygLowmfM3uTeh27X6iIxEgiVSKR0fgkHinVMMWBMGhAcIVYrOWId76EIe6zX2w0ASFxdnau6ujdqZexcM7wd4FRA4XAsUujiJdZgGoN4wCB0EU6l6tBfaQCXc3L6I7Ulhf4EipECHUAAaTcPnA3LJadwD1QDU76IUALp4QaGe3ANFa4zDFTRqw2ZxGOgFIoiVtecZow/Qvos7ACD6OyiIOAIAYFCwNuqB2sww5xdiTr9mbdp0GSTMLrPiQaqIA7448F70+qV9qB6/rQQAWJxgdgMAEFRwYHALwtSmbcDrMCiPkuAQbNF0GTNmxoa3tZojXDUIpak9T4Sl3EErrXZIiZHHoBC8GAEMGA1lwuCB0dAUYB5RAQBO6EMvutGFtu2amxUHxaFxbBwXp+IsXCyuxYuIdcgHSWPIcNIzJwvEhKCzbePS8zzNq5su6HUqfoTjFCPyj4UcA3sMQp9R3wwaWNaxADPPDgAAspCFDGT2krzd5//wh4/38f1+ftzPzo0D42LxKJ7hDSIKCHJsJRcdghG2x1gYD1TTgik1DGXdMFRLfG5mKUUAeDPMtuFiJsjsqZIb6Bs6LadrnIcHeIaX8AZBEMQrzKOcey1AaRrYFqRKQbDZbLDoYTniLwh51UHmOdlKgWLuHkcHJM2ynzRY7UOtFNoaAsUEH3BfgK1BZoZ5lcAhh0Ug8B+yE6VSROoLFAXgy1Beh7beQHOkSpCdgWAfamEOvBc308BWUK8UacGHw+zTSHHMyVTHWCSb/EDzrjggzP19owgI89jJWGdEHIQdbqCicyZTLWkTwlPwaabKSTZBxB2Dz+rXAUd8pA48wWvIooaoTUHn2kZh6kfCedXOIF0tEm+KymRD9DFonAQAIDvGDASnIUKdgmsfH4ECLbNUnCxDyZbuyka6xLytN0VRxLkUNF7+MnKnE0nAaTBRppCaM2P212F/zgCjPl7Y1DIt4dawxuoaDJgBAGxxlypwCt27t6ujYbzwlGzWmlsDPAwcpAMA8jII9AH/IfVpuvB4TOrkTVGSdVaF1QZM3sARXFlNDfiGd31YqOfxCSVNl/YVVd0U/2UdpfDMiNu5dD79VkfeUwM2IaqPkMZxNNKK0/knXEsGUD6NIimyQuW4zm7gyQy6vgV0/JFXmBKQDZTkg0yZAS9bphUIhzHnAtU8nF3oQeTwp2EOEEIRRx6PoOvZ/NDWUgE+YFqU8wgRjwDAYXDZDsNx9C2IdCB/GUbgpJS9b7hr2F9ci6kTIxAX5cyCPITUPCkpTAoZ03DSE0k94odhdhRgd8NthtNixokgoCjnDkMo1XZ77FGVRiXgPABZEyeSW5QiyFqG94R5W5PbiPPFlIkraLfI+LM9RRc/zapkEsaLFnotpGv4q4E+Ur0mZPxbcWfxJKZMFEPQorp96myalWRakeVkIp6INTpqMWv2ljiqFhtC6MIUFxazJS+tswDhxfYXzzDDhAdQluMrspgxdPSlYdVM9z/X4VBco8baepcZC4egaxrqETUhCeuufxVNdctFmmkylLIV/AePMFViAfKF+aForFJl7AWamAIcSsOSCBqC7CNc1zeUnLlCLYRnFZgma5tBN5iSEAcEHVWSyH5H7KGrNak8B0O54ez5sgHqQUjEnEZEnIyfqSzCLSzumHyxYS2077/Zk1SmxU8niwnWfLMWkfd1P5p5UacRFgcj4yGE6T26gTsmZxOkuPvmA9nxhL72a2Ln7X60dwMczGCENA7YRJJGsHkK4LSewhAfr/ejvRw0AwmELSi0jpz3yaVpPj6JJs38iu81J6SDL78coCyBUAa0DoiL93L7FiuoPN0zNdnN+WUTTYDq+340UrEWn00+/AgAQsPjNh7hEl04387w8iWEhwzstKznaYJpc3kOIM9Blg7svttNZFiD6Od2h3TwI1AQ37PJocXDUGlm9EUemj6d4V0TGJZZsTkFq0DTSWYYrIrA3W4ZKjR64K6/nBGB1Ch2eeeJx7t6qYgakhyP3NvXE1epTCPxVKHm14N+NEMvPFabPFW9x6tVx56sXHWFoMoj5+NjouNqm0y9GpfAP/y1SFBfSKAoQIxwHhSrgQxvCQwBQBFlIUIRWSJCuAiRvOr6C3sRIsTwaZsvjESIFCZcLK+q4GQF3TYBR3vsZNwI7MQzrQAOYjn+aOLp9XlRrbSJKQK4qHzQifpCAkvtJiCJDquKAVGGaTkAuGLSw6JgbMyEORJS78gVhH+JiU0Re0K/GBwnMUdsEnpb10iVm7KjDmAXlllo0hZQlSbby9tUmPCbBVBhstGAA9gQmhAPLqpsGJba2GJCnbohkeUFIQLqYQC0t1UiZiTQQ8VuSaqr9+5An2QYgBLLrUec+/6HBF5KqftsavvShn7ojmS9NlaD232xXP0zoNudZjUp9EWTbvbgnlLWbt6cwbbVzQYTMgeKoRfl1omiBQqlYwaPThExJcUXRq+vnrkFnQLSoQcUqkJ8Wk9xF9pXAVqhYn79pq2ir8ipgpCEuYxGQ9AEpQFADlxUm6D/5JG0g+6/cAP0ob66ze8EdEFiX6xgSgAhxG13KTegT64YhI61+5R10Ks+Q4iF2iB0j2M1hKg1oxlq9KLRUMwRMQMAARHcU3ehNFegF9XwC2vAH+qsO7GcCQ0RQouqiKlpU+5Id518RSiHEEJ17XFoGUDFNt+gpnpnDdFg2n6VEDYaVZOm+QCuXsinCG4pR3wISaFJ/gXBBh3aYJUuqLySEFVBqLnd4phCAuGUGbWHNTehbInQs6NQkCsN2A1xy5H8FPXQSgb4PUAN9JWfY1A3dXBJEVyGPsmU5TVUiAAAeH7EFISa+66kzTCsBTMzB3GNYWqq71RBe8nqh/a1T2yEPvQp+o/QMw4xsKDSqnQbulJVHkKHgWTYf4SdXmjCFPSaKrikFBUYEwgAX2NKyitXGGnUocM3Vxh2FF312pg2Aj2vtGjXpc/zeom47n+7gMNGlbYXuwg24M8OlWy0HlUny1UlMZ6cdrzKJaO2VYA0zdYC2ur09gPvrJXg4HojFgH8R7IA" alt="Admin Logo" class="img-circle img-logo" style="opacity: .8; max-height:40px;">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
