<h2><?= $subscriber->first_name ?> <?= $subscriber->last_name ?></h2>
Active: <?= $subscriber->active ?><br/>
Email: <?= $chargeBee->email ?><br/>
Phone: <?= $subscriber->phone ?><br/>
Last Updated: <?= $chargeBee->updatedAt ?><br/>
<br/>
<div class="panel panel-default">
  <div class="panel-heading">Address</div>
  <div class="panel-body">
    <?= $subscriber->street1 ?><br/>
    <?= $subscriber->strett2 ?><br/>
    <?= $subscriber->city ?>, OH<br/>
  </div>
</div>
</div>
