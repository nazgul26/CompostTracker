<h2><?= $subscriber->first_name ?> <?= $subscriber->last_name ?></h2>
Active: <?= $subscriber->active ?><br/>
Email: <?= $subscriber->email ?><br/>
Phone: <?= $subscriber->phone ?><br/>
Pickup Location: <?= $subscriber->bucket_location ?> <br/>
<br/>
<div class="panel panel-default">
  <div class="panel-heading">Address</div>
  <div class="panel-body">
    <?= $subscriber->street1 ?><br/>
    <?= $subscriber->street2 ?><br/>
    <?= $subscriber->city ?>, OH<br/>
  </div>
</div>
</div>
