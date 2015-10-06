<?php if(count(get_included_files()) ==1) exit("Direct access not permitted."); ?>
<html>
  <head><title>@dwijonarko</title></head>
  <body>
    <div id="photo_tweet">
  <h2>Photo Tweet</h2>
  <p>Hello, @<?php echo htmlspecialchars($ta->userdata->screen_name) ?>.</p>
  <form action="" method="POST" enctype="multipart/form-data">
    <div>
      <label for="status">Tweet Text</label>
      <textarea type="text" name="status" rows="5" cols="60"></textarea>
      <br />

      <label for="image">Photo</label>
      <input type="file" name="image" />
      <br />
      <input type="submit" value="Submit" name="tweet" />
    </div>
  </form>
  </div>
  </body>
</html>

