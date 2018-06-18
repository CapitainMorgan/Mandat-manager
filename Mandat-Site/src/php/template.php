<?php
session_start();
?>
<nav>
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link active" href="#">Mandats</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Calendrier</a>
    </li>
  </ul>
</nav>
<section>
  <h4>Bonjour <?php print $_SESSION['pseudo']; ?></h4>
  
</section>

<footer>

</footer>
