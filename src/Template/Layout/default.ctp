<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Rust Belt Riders';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
 
    <?= $this->Html->css('custom') ?>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <?= $this->Html->script('https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key=AIzaSyCOT70OMdcdZrHZKEOYc-tgsFLE8QriPOM')?>

    <?= $this->Html->script('Chart.bundle.min.js'); ?>
    <?= $this->Html->script('jquery.inputmask.bundle.min.js'); ?>
    <?= $this->Html->meta('favicon.ico','img/favicon.ico',array('type' => 'icon'));?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" href="#">
        <?= $this->Html->image("logo.png", ["alt" => "RBR", "class" => "brandImage"])?>
        </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <?php 
            if (isset($userId)) {
                if ($isEmployee) {
                    echo "<li id='navAddCommercialPickup'>";
                    echo $this->Html->link('<i class="fas fa-dolly-flatbed fa-2x"></i>', 
                    ['controller' => 'Pickups', 'action' => 'add'],
                    ['escape' => false, 'title' => 'Add Commercial Pickup']);
                    echo "</li>";

                    echo "<li id='navAddResidentialPickup'>";
                    echo $this->Html->link('<i class="fas fa-dolly fa-2x"></i>', 
                    ['controller' => 'Collections', 'action' => 'add'],
                    ['escape' => false, 'title' => 'Add Residential Collections']);
                    echo "</li>";
                }
            ?>
            <li id="navReports">
                <?= $this->Html->link('<i class="fas fa-chart-bar fa-2x"></i>', 
                ['controller' => 'Reports', 'action' => 'index'],
                ['escape' => false, 'title' => 'Reports']); ?>
            </li>

            <?php if ($isResidential) {
                echo "<li class='navHiRes'>";
                echo $this->Html->link('<i class="fas fa-credit-card fa-2x"></i>', 
                ['controller' => 'Payments', 'action' => 'index'],
                ['escape' => false, 'title' => 'Payment Options']);
                echo "</li>";

                echo "<li class='navHiRes'>";
                echo $this->Html->link('<i class="fas fa-shopping-cart fa-2x"></i>', 
                ['controller' => 'Settings', 'action' => 'index'],
                ['escape' => false, 'title' => 'Buy Additional Services/Products']);     
                echo "</li>";

                echo "<li>";
                echo $this->Html->link('<i class="fas fa-cogs fa-2x"></i>', 
                ['controller' => 'Settings', 'action' => 'index'],
                ['escape' => false, 'title' => 'Service Options']);
                echo "</li>";
            } ?>

            <li id="navAccount">
                <?= $this->Html->link('<i class="fas fa-user fa-2x"></i>', 
                ['controller' => 'Users', 'action' => 'edit', $userId],
                ['escape' => false, 'title' => 'Your Account']);?>
            </li>

            <?php if ($isEmployee) { ?>
            <li class="dropdown navHiRes" id="navAdmin">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-wrench fa-2x"></i><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li>
                        <?= $this->Html->link('Commercial Pickups', 
                        ['controller' => 'Pickups', 'action' => 'index']); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('Residential Pickups', 
                        ['controller' => 'Collections', 'action' => 'index']); ?>
                    </li>
                    <?php if ($isAdmin) {?>
                    <li>
                        <?= $this->Html->link('User Administrator', 
                        ['controller' => 'Users', 'action' => 'index']);?>
                    </li>

                    <li>
                        <?= $this->Html->link('Clients', 
                        ['controller' => 'Clients', 'action' => 'index']); ?>
                    </li>

                    <li>
                        <?= $this->Html->link('Containers', 
                        ['controller' => 'Containers', 'action' => 'index']);?>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <li>
                <?= $this->Html->link('<i class="fas fa-sign-out-alt fa-2x pull-right"></i>', 
                ['controller' => 'Users', 'action' => 'logout'],
                ['escape' => false, 'title' => 'Sign Out']);
                ?>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
</nav>

    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>
    <footer>
    </footer>
</body>
</html>
