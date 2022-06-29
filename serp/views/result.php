<?php require_once('header.php'); ?>
  <a href="index.php">← Back</a>
  <?php if (isset($errors)): ?>
    <h3>Errors</h3>
      <?php foreach ($errors as $error) : ?>
        <pre><?php echo $error['detail'] ?></pre>
      <?php endforeach; ?>
  <?php endif; ?>
  <?php if (isset($status) && $status['status'] != 'finished'): ?>
    <h3>Task status</h3>
    <pre><?php print_r($status) ?></pre>
  <?php endif; ?>
  <?php if (isset($results)): ?>
    <h3>Result</h3>
    <pre><?php print_r($results) ?></pre>
  <?php elseif (isset($taskId)): ?>
    <form method="get">
      <input type="hidden" name="taskId" value="<?php echo $taskId ?>">
      <input type="submit" value="Update">
    </form>
  <?php endif; ?>
<?php require_once('footer.php'); ?>
