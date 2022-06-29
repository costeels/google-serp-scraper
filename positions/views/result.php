<?php require_once('./views/header.php'); ?>
  <a href="index.php">← Back</a>
  <?php if (isset($errors)): ?>
    <h3>Errors:</h3>
      <?php foreach ($errors as $error) : ?>
        <pre><?php echo $error['detail'] ?></pre>
      <?php endforeach; ?>
  <?php endif; ?>
  <?php if (isset($status) && $status['status'] != 'finished'): ?>
    <h3>Task status:</h3>
    <pre><?php print_r($status) ?></pre>
  <?php endif; ?>
  <?php if (isset($domain)): ?>
    <h3>Domain:</h3>
    <pre><?php echo $domain ?></pre>
  <?php endif; ?>
  <?php if (isset($positions)): ?>
    <h3>Positions:</h3>
      <?php foreach ($positions as $position) : ?>
        <?php if ($position['position']): ?>
          <pre><?php echo $position['query'] ?> => <?php echo $position['position'] ?> (<?php echo $position['url'] ?>)</pre>
        <?php else: ?>
          <pre><?php echo $position['query'] ?> => N/A</pre>
        <?php endif; ?>
      <?php endforeach; ?>
  <?php elseif (isset($taskId)): ?>
    <form method="get">
      <input type="hidden" name="taskId" value="<?php echo $taskId ?>">
      <input type="submit" value="Update">
    </form>
  <?php endif; ?>
<?php require_once('./views/footer.php'); ?>
