
<?php if (isset($todos) && $todos !== array()): ?>

  <div class="itp-itemPagenator">
  <?php
  $this->Paginator->options(array(
      'update' => '#itp-itemPages'
  ));
  echo $this->Paginator->prev('«Prev', null, null, array('class' => 'disabled.')) . '&nbsp;';
  echo $this->Paginator->numbers(array('separator' => '&nbsp;', 'modulus' => 8)) . '&nbsp;';
  echo $this->Paginator->next('Next»', null, null, array('class' => 'disabled.'));
  ?>
</div>							

<?php
  foreach ($todos as $k => $todo) {

    //$todos[$k]['Item']['nust'] = 'cor';

    $statusClass = "itS0";
    $statusText = "opend";
    if ($itemStatuses) {
      foreach ($itemStatuses as $v) {
        if ($todo['Item']['status'] == $v['n']) {
          $statusClass = "itS" . $v['n'];
          $statusText = $v['t'];
        }
      }

      unset($todos[$k]['Item']['status']);

      $todos[$k]['Item']['statusClass'] = $statusClass;
      $todos[$k]['Item']['statusText'] = $statusText;
    }

    $taskClass = "itT0";
    $taskText = "todo";
    if ($itemTasks) {
      foreach ($itemTasks as $v) {
        if ($todo['Item']['task'] == $v['n']) {
          $taskClass = "itT" . $v['n'];
          $taskText = $v['t'];
        }
      }
      unset($todos[$k]['Item']['task']);
      $todos[$k]['Item']['taskClass'] = $taskClass;
      $todos[$k]['Item']['taskText'] = $taskText;
    }

    $formatedDate = ''; //__('No target',true);
    if (!empty($todo["Item"]["target"])) {
      $date = new DateTime($todo["Item"]["target"]);
      $formatedDate = $date->format('d.m.Y');
    }
    $todos[$k]['Item']['target'] = $formatedDate;

    if (!empty($todo["Item"]["created"])) {
      $todos[$k]["Item"]["created"] = $timenomin->timeAgoInWords($todo["Item"]["created"]);
    }
  }
?>						




<?php $comToDos = $todos; ?>
<?php $todosObj = $js->object($comToDos); ?>
<?php //echo $html->scriptBlock('jQuery(document).ready(function(){   $("#itp-itemPages").data( "todosObj",'.$todosObj.');  });',array('inline'=>true));  ?>
<?php echo $html->scriptBlock('jQuery(document).ready(function(){$("#itp-itemTmpl").tmpl('. $todosObj.').appendTo($("#itp-itemPages"));  });', array('inline' => true)); ?>

<?php else: ?>
    <div style="text-align:center;"><?php __('No items in the list yet.'); ?></div>
<?php endif ?>





<?php echo $this->Js->writeBuffer(); ?>


	

