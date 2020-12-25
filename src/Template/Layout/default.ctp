<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= env('COMPANY_NAME') ?>:
        <?= $this->fetch('title') ?>
    </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
 
    <?= $this->Html->css('custom') ?>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <?= $this->Html->script('Chart.bundle.min.js'); ?>
    <?= $this->Html->script('jquery.inputmask.bundle.min.js'); ?>
    <?= $this->Html->meta('favicon.ico','img/favicon.ico',array('type' => 'icon'));?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?php if (isset($userId)) : ?>

    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header navHiRes">
            <div class="smallLogo">
                <?= env('LOGO_LETTERS') ?>
            </div>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <?php 
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

            <li id="navHome" class='navHiRes'>
                <?= $this->Html->link('<i class="fas fa-home fa-2x"></i>', 
                ['controller' => 'Home', 'action' => 'index'],
                ['escape' => false, 'title' => 'Home']); ?>
            </li>


            <?php if ($isEmployee) { ?>
                <li class="dropdown navHiRes" id="navReports">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-chart-bar fa-2x"></i><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li>
                        <?= $this->Html->link('Commercial Reports', 
                        ['controller' => 'Reports', 'action' => 'index']); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('Residential Reports', 
                        ['controller' => 'Reports', 'action' => 'residential']); ?>
                    </li>
                </ul>
            </li>
            <?php } else { ?>
                <!-- Commercial Clients Reporting -->
                <li id="navReports">
                <?= $this->Html->link('<i class="fas fa-chart-bar fa-2x"></i>', 
                ['controller' => 'Reports', 'action' => 'index'],
                ['escape' => false, 'title' => 'Reports']); ?>
                </li>
            <?php } ?>

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
                    <li>
                        <?= $this->Html->link('Residential Subscribers', 
                        ['controller' => 'Subscribers', 'action' => 'index']); ?>
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
                    <li>
                        <?= $this->Html->link('Drop Off Locations', 
                        ['controller' => 'Dropoffs', 'action' => 'index']);?>
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

        </ul>
    </div>
</div>
</nav>
<?php endif; ?>
    <br/>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>
    <div class="shim"></div>
    <div class="footer social navbar-fixed-bottom">
        <a href="https://facebook.com/<?=env('COMPANY_FACEBOOK')?>" target="_blank"><i class="fab fa-facebook-square fa-2x"></i></a>
        <a href="https://twitter.com/@<?=env('COMPANY_TWITTER')?>" target="_blank"><i class="fab fa-twitter-square fa-2x"></i></a>
        <a href="mailto:<?=env('COMPANY_EMAIL')?>" target="_blank"><i class="fas fa-envelope-square fa-2x"></i></a>
        <p><?= env('COMPANY_ADDRESS') ?><br/><?= env('COMPANY_PHONE_NUMBER') ?></p>
    </div>
</body>
</html>
