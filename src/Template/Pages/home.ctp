 <h2>Rust Belt Riders Tracking Application</h2>
 <hr/>
 <ul class="menu">
    <?php if ($isAdmin) : ?>
    <li><?= $this->Html->link('Clients', ['controller' => 'Clients', 'action' => 'index'])?></li>
    <li><?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index'])?></li>
    <li><?= $this->Html->link('Containers', ['controller' => 'Containers', 'action' => 'index'])?></li>
    <?php endif?>
    <?php if ($isUser) : ?>
    <li><?= $this->Html->link('Pickups', ['controller' => 'Pickups', 'action' => 'index'])?></li>
    <li><?= $this->Html->link('Your Account', ['controller' => 'Users', 'action' => 'edit', $userId])?></li>
    <?php endif ?>

    <?php if ($isClient) : ?>
    <li><?= $this->Html->link('Reports', ['controller' => 'Reports', 'action' => 'index'])?></li>
    <li><?= $this->Html->link('Log Out', ['controller' => 'Users', 'action' => 'logout'])?></li>
    <?php endif ?>
</ul>