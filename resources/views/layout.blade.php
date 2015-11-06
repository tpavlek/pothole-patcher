<!DOCTYPE html>
<html>
<head>
    <style>
        body { margin: 0; padding: 0;}
    </style>
@yield('title', "")
</head>
<body>

@yield('content')

<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="/js/phaser.min.js"></script>
@yield('scripts')
</body>
</html>
