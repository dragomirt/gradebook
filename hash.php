<?php
if(isset($_POST['txt'])){
  $txt = $_POST['txt'];
  $salt1 = "io65$"; $salt2 = 'jb#pp1';
  $password = hash('ripemd128' , "$salt1$txt$salt2");
  echo $password;
}

echo <<<_END
<form action="hash.php" method="post">
<input type='text' name='txt'>
<input type="submit">
</form>
_END;
 ?>
