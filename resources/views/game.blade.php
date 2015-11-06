@extends('layout')

@section('title')
@stop

@section('content')

@stop

@section('scripts')
    <script>
        //var width = $(window).width();
        //var height = $(window).height();
        var game = new Phaser.Game(1000, 800, Phaser.AUTO, '', { preload: preload, create: create, update: update });

        function preload() {
            game.load.image('bg', '');
            game.load.image('pothole', 'img/pothole.jpg');
        }
        var potholeGroup;
        function create() {
            //  A simple background for our game
            game.add.sprite(0, 0, 'bg');

            potholeGroup = game.add.group();

            var pothole = potholeGroup.create(0, 0, 'pothole');

            game.physics.startSystem(Phaser.Physics.ARCADE);

        }
        function update() {

        }
    </script>
@stop
