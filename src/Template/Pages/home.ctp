 <ul>
    <li><?= $this->Html->link('Pickups', ['controller' => 'Pickups', 'action' => 'index'])?></li>
    <li><?= $this->Html->link('Clients', ['controller' => 'Clients', 'action' => 'index'])?></li>
    <li><?= $this->Html->link('Reports', ['controller' => 'Reports', 'action' => 'index'])?></li>
    <li><?= $this->Html->link('Add User', ['controller' => 'Users', 'action' => 'add'])?></li>
    <li><?= $this->Html->link('Log Out', ['controller' => 'Users', 'action' => 'logout'])?></li>
</ul>