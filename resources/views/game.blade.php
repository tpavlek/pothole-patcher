@extends('layout')

@section('title')
@stop

@section('content')

@stop

@section('scripts')
    <script>
        //var width = $(window).width();
        //var height = $(window).height();
        var game = new Phaser.Game(900, 900, Phaser.AUTO, '', { preload: preload, create: create, update: update });

        function preload() {
            game.load.image('bg', 'img/streetview.jpg');
            game.load.image('pothole', 'img/pothole.jpg');
            game.load.image('asphalt', 'img/asphalt.jpg');
        }

        var pothole;
        var player;
        var cursors;
        var spacebar;

        function create() {
            game.physics.startSystem(Phaser.Physics.ARCADE);
            //  A simple background for our game
            var background = game.add.sprite(0, 0, 'bg');
            background.scale.setTo(1.5, 1.5);

            pothole = game.add.sprite(0, 0, 'pothole');
            pothole.scale.setTo(0.8, 0.8);



            player = game.add.sprite('400', '400', 'asphalt');
            player.scale.setTo(0.25, 0.25);

            cursors = game.input.keyboard.createCursorKeys();
            spacebar = game.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR);
            player.x = 400;
            generatePotHoleTarget(pothole);
            pothole.lives = 1;

        }
        function update() {

            if (hasGameEnded()) {
                return;
            }
            movePlayer();
            movePotHole();
            shoot();
        }

        function hasGameEnded()
        {
            return (pothole.lives < 1);
        }

        function movePotHole()
        {
            if (hasHitBound(pothole, 0, pothole.xtarget, pothole.ytarget)) {
                console.log("Target Now:" + pothole.xtarget + " " + pothole.ytarget);
                generatePotHoleTarget(pothole);
            }

            if (pothole.x < pothole.xtarget) {
                pothole.x += 5;
            }

            if (pothole.x > pothole.xtarget) {
                pothole.x -= 5;
            }

            if (pothole.y > pothole.ytarget) {
                pothole.y -= 5;
            }

            if (pothole.y < pothole.ytarget) {
                pothole.y += 5;
            }
        }

        function shoot()
        {
            if (spacebar.isDown) {
                var playerX = player.x + (player.width / 2);
                var playerY = player.y - (player.height / 2);
                if (playerX < (pothole.x + pothole.width) && playerX > pothole.x && playerY < pothole.y && playerY > (pothole.y - pothole.height)) {
                    pothole.lives -=1;
                }

            }
        }

        function movePlayer()
        {
            var newX;
            var newY;
            if (cursors.left.isDown)
            {
                newX = player.x - 4;
                if (newX < 0) {
                    return;
                }
                //  Move to the left
                player.x -= 4;

            }
            if (cursors.right.isDown)
            {
                newX = player.x + 4;

                if (newX + player.width > game.width) {
                    return;
                }
                //  Move to the right
                player.x = newX;

            }
            if (cursors.down.isDown)
            {
                newY = player.y + 4;

                if (newY + player.height > game.height) {
                    return;
                }
                player.y = newY;
            }

            //  Allow the player to jump if they are touching the ground.
            if (cursors.up.isDown )//&& player.body.touching.down)
            {
                if (hasHitBound(player, -4)) {
                    return;
                }
                player.y -= 4;
            }
        }

        function generatePotHoleTarget(pothole)
        {
            // We're near the left, assume we hit that side.
            if (pothole.x <= 10) {
                pothole.ytarget = getRandomInt(0, game.height);
                pothole.xtarget = game.width;
                return;
            }

            // We're near the top, assume we hit the top
            if (pothole.y <= 10) {
                pothole.ytarget = game.height;
                pothole.xtarget = getRandomInt(0, game.width);
                return;
            }

            // We hit the bottom
            if (pothole.y + pothole.height >= game.height - 10) {
                pothole.ytarget = 0;
                pothole.xtarget = getRandomInt(0, game.width);
                return;
            }

            // We hit the right
            if (pothole.x + pothole.width >= game.width - 10) {
                pothole.ytarget = getRandomInt(0, game.height);
                pothole.xtarget = 0;
                return;
            }

        }

        function hasHitBound(sprite, checkahead, totalWidth, totalHeight)
        {
            if (checkahead == undefined) {
                checkahead = 0;
            }
            if (totalWidth == undefined) {
                totalWidth = game.width;
            }
            if (totalHeight == undefined) {
                totalHeight = game.height;
            }
            var x = sprite.x + checkahead;
            var y = sprite.y + checkahead;
            if (x < 1 || y < 1) return true;
            if (x + sprite.width > totalWidth) { return true; }
            if (y + sprite.height > totalHeight) { return true; }
            return false;
        }

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min)) + min;
        }
    </script>
@stop
