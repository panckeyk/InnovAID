<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ config('app.name', 'Laravel') }} </title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div>

        <a href=""
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center"> Welcome to InnovAID </h5>
            <p class="font-normal text-gray-700 dark:text-gray-400"> gaggo wag na natin ituloy to HAHAHAH </p>
        </a>

    </div>
</body>

</html>