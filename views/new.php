<html lang="en">
  <body>
    <?php if (isset($errors)): ?>
      <h3>Errors:</h3>
        <?php foreach ($errors as $error) : ?>
          <pre><?php echo $error['detail'] ?></pre>
        <?php endforeach; ?>
    <?php endif; ?>
    <form method="post">
      <label>keywords*:
        <textarea id="keywords" name="keywords"><?php echo isset($_POST['keywords']) ? $_POST['keywords'] : '' ?></textarea>
      </label><br>
      <label>googleId:
        <input type="number" id="googleId" name="googleId" value="<?php echo isset($_POST['googleId']) ? $_POST['googleId'] : '' ?>">
      </label><br>
      device:
      <label>desktop
        <input type="radio" name="device" value="desktop" <?php echo (isset($_POST['device']) ? $_POST['device'] : '') == 'desktop' ? 'checked' : '' ?>>
      </label>
      <label>mobile
        <input type="radio" name="device" value="mobile" <?php echo (isset($_POST['device']) ? $_POST['device'] : '') == 'mobile' ? 'checked' : '' ?>>
      </label><br>
      <label>hl
        <input type="text" name="hl" value="<?php echo isset($_POST['hl']) ? $_POST['hl'] : '' ?>">
      </label><br>
      noreask:
      <label>0
        <input type="radio" name="noreask" value="0" <?php echo (isset($_POST['noreask']) ? $_POST['noreask'] : '') == '0' ? 'checked' : '' ?>>
      </label>
      <label>1
        <input type="radio" name="noreask" value="1" <?php echo (isset($_POST['noreask']) ? $_POST['noreask'] : '') == '1' ? 'checked' : '' ?>>
      </label><br>
      <input type="submit" value="Create">
    </form>
  </body>
</html>
